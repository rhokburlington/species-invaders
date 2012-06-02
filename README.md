SPECIES INVADERS
================

An "invasive species" RESTful API for [Random Hacks of Kindness](http://www.rhok.org/problems/invasive-species-identification).

OVERVIEW
--------

Proposed use-cases for apps/sites/widgets which would use this API:

- Browse by "activity" (e.g. "camping", "hiking", "canoeing", "fishing", etc.)
- "I'm going from/to here, what should I watch out for?"
- "I'm here, what should I watch out for?"
- "I see something, what is it? Is it invasive?"
- "This place has something invasive, others should be aware!"
- The ability to administer the data sets

We'll be developing a RESTful API in PHP, initially responding w/JSON data, and hopefully a proof-of-concept JavaScript widget.

API SCHEMA
----------

Fetch data via GET & create/update data via POST. Querying specific data from an endpoint can be done by including appropriate query string parameters. Returns JSON, possibly JSON-P if a callback is specified in the query string.

Endpoints:

- /species
  - Optional parameters:
    - id (species id)
    - name (species)
    - common_name
    - polygon
    - q (search query)
  - /species/locations
  - /species/info
  - /species/common_name
- /location
  - Optional parameters:
    - id (location id)
    - polygon
- /activity
  - Optional parameters:
    - id (activity id)
    - name
    - q (search query)
