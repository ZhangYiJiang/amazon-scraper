from result import AuthorPage
import argparse
import json

# Parse command line arguments
parser = argparse.ArgumentParser(description="Scrapes Amazon search results from a given keyword")
parser.add_argument("url", help="Author page URL to scrape from")

args = parser.parse_args()

author_page = AuthorPage(args.url)
author = {}

try:
    author['bio'] = author_page.bio
    print(json.dumps(author))
except Exception as e:
    pass

