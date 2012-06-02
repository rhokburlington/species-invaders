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

- /species (returns array of species IDs)
  - /species/id/{id} (returns a single species object)
  - /species/name/{name}
  - /species/common_name/{common_name}
  - /species/polygon/{polygon}
  - /species/query/{search query}
  - /species/locations
  - /species/info
  - /species/common_name
- /location
  - /location/id/{id}
  - /location/polygon/{polygon}
- /activity
  - /activity/id/{id}
  - /activity/name/{name}
  - /activity/query/{search query}

IMPLEMENTATION CONSIDERATIONS
-----------------------------

We're developing in PHP and intend to use the [Wikipedia API](http://www.mediawiki.org/wiki/API) & [Google Maps API](https://developers.google.com/maps/documentation/), fortunately MySQL supports [geometry functions](http://dev.mysql.com/doc/refman/4.1/en/geometry-property-functions.html) so we can store/process our polygons natively there. We started with Scott Markoski's [Silent Running](https://github.com/smarkoski/sr-framework) framework due to familiarity for implementation speed.

