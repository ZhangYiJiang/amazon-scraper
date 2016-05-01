from result import SearchPage
from argparse import ArgumentParser
import json
import sys

# Parse command line arguments
parser = ArgumentParser(description="Scrapes Amazon search results from a given keyword")
parser.add_argument("keyword", help="Search keyword to scrape from")
parser.add_argument("-p", "--page", type=int, default=1, help="Page to scrape from. Default: first page")

args = parser.parse_args()

# Get page from Amazon
search_page = SearchPage(args.keyword)
books = []

for result in search_page.results():
    # Ignore sponsored content
    if result.sponsored:
        continue

    book = {}

    try:
        book_page = result.book_page()
        book['description'] = book_page.description
        book['isbn'] = book_page.isbn
        book['rating'] = book_page.rating

        book['title'] = result.title
        book['url'] = result.url
        book['asin'] = result.asin
        book['author_name'] = result.author_name
        book['cover_url'] = result.cover_url
        book['price'] = result.price
        book['author_url'] = result.author_url
    except Exception as e:
        exc_type, exc_obj, exc_tb = sys.exc_info()
        print(str(type(e)) + ' ' + str(exc_tb.tb_lineno), file=sys.stderr)
        print(e, file=sys.stderr)
    else:
        books.append(book)

print(json.dumps(books))
