import re
import json
from time import sleep
import sys
import os
import requests
from bs4 import BeautifulSoup
from urllib.parse import urljoin

with open(os.path.dirname(os.path.realpath(__file__)) + "/config.json") as f:
    config = json.load(f)


def match(str):
    return re.compile(str, re.I)


class Page:
    def __init__(self, url, params=None):
        while True:
            try:
                r = requests.get(url, params=params)
                r.raise_for_status()
                break
            except requests.exceptions.HTTPError as e:
                # Can't do anything about client errors (HTTP 4XX)
                if r.status_code < 500:
                    raise e
                else:
                    print(e, file=sys.stderr)
                sleep(config['error_wait_time'])

        self.page = BeautifulSoup(r.text, 'html.parser')

    @staticmethod
    def preprocess_link(url):
        return urljoin(config['url_base'], url)


class SearchPage(Page):
    def __init__(self, keyword):
        super().__init__(config['url_base'], {config['query_param']: keyword})

    def results(self):
        return [Result(e) for e in self.page(class_='s-result-item')]


class Result:
    def __init__(self, element):
        self.result = element
        self._heading = self.result.find('h2')

    def _author_element(self):
        try:
            element = self._author_span
        except AttributeError:
            row = self._heading.find_parent(class_='a-row')
            element = row.find(string=match('by')).parent.next_sibling
            self._author_span = element
        return element

    @property
    def asin(self):
        return self.result['data-asin']

    @property
    def title(self):
        return self._heading.text

    @property
    def url(self):
        url = self._heading.find_parent('a')['href']
        return Page.preprocess_link(url)

    @property
    def author_name(self):
        return self._author_element().text

    @property
    def author_url(self):
        try:
            url = self._author_element().find('a')['href']
            return Page.preprocess_link(url)
        except (AttributeError, TypeError):
            return None

    @property
    def price(self):
        prices = {}

        for p in self.result(class_='a-color-price', string=match('$')):
            try:
                row = p.find_parent(class_='a-row')
                edition = row.previous_sibling.find('h3')
                prices[edition.text] = float(p.text.strip().lstrip('$'))
            except (AttributeError, ValueError):
                pass

        return prices

    @property
    def sponsored(self):
        return self.result.find(class_='s-sponsored-info-icon') is not None

    @property
    def cover_url(self):
        url = self.result.find('img')['src']
        return Page.preprocess_link(url)

    def book_page(self):
        return BookPage(self.url)

    def bio_page(self):
        return AuthorPage(self.author_url)


class BookPage(Page):
    def __init__(self, url):
        super().__init__(url)

    @property
    def isbn(self):
        table = self.page.find(id='productDetailsTable')
        try:
            isbn = table.find(string=match(r'ISBN-13')).parent.next_sibling
        except AttributeError:
            try:
                isbn = table.find(string=match(r'ISBN-10')).parent.next_sibling
            except AttributeError:
                return None
        return str(isbn).strip()

    @property
    def rating(self):
        rating_element = self.page.find(id='avgRating')
        match = re.search(r"(\d(\.\d)?) out of 5 stars", rating_element.text, re.I)
        if match:
            return match.group(1)
        return None

    @property
    def description(self):
        container = self.page.find(id="bookDescription_feature_div")
        try:
            # inner HTML
            noscript = container.find('noscript')
            return noscript.decode_contents(formatter="html")
        except AttributeError:
            return None


class AuthorPage(Page):
    def __init__(self, url):
        super().__init__(url)

    @property
    def bio(self):
        return self.page.find(id='ap-bio').text.strip()
