# [Copyright](https://www.protocols.io/private/96BF0EC8DD3D11F0AB9E0A58A9FEAC02) © 2025 Isabel Schöps (Thiel). 

## [About Isabel Schöps geb. Thiel](https://fairsharing.org/users/16106) 

The simple search is appropriate for quickly searching for a record by means of some text (e.g. part of the name, description or URL) and narrowing this search down by means of some simple facets. If you need more complex search and filter options then the advanced search should provide them.

Due to the nature of these searches it is quite possible to construct a search that returns no results, for example by searching for records that are both standards and knowledgebases (no such record exists), so care must be taken when constructing the query.

## Getting Started

Advanced search can be found at the top of the FAIRsharing page.

<figure><img src="https://isabelschoepsthiel-files.gitbook.io/~/files/v0/b/gitbook-x-prod.appspot.com/o/spaces%2F-Mcht5-9Lysnv_oQFJJh%2Fuploads%2FfzpYL4IGpjmPhvuKsBVi%2FScreenshot%20from%202024-03-06%2012-58-04.png?alt=media&#x26;token=12b23503-ad10-4f28-9d1d-dbb3edeeaa6b" alt=""><figcaption><p>The location of the advanced search button</p></figcaption></figure>

Clicking it will cause the advanced search interface to open over the top of the rest of the page.

Advanced search allows you to create several "groups" of conditions which are joined together by "operators" - AND or OR. AND means that all the conditions must match and OR means that any of them may. Each group may contain one or more "rules", each linked by their own operator.&#x20;

To illustrate this an example query has been constructed below:

<figure><img src="https://isabelschoepsthiel-files.gitbook.io/~/files/v0/b/gitbook-x-prod.appspot.com/o/spaces%2F-Mcht5-9Lysnv_oQFJJh%2Fuploads%2FVjoA7RN507B6Q6jnaobt%2FScreenshot%20from%202024-03-06%2013-04-24.png?alt=media&#x26;token=35649c9b-ad2e-4e60-9367-7cf877985d34" alt=""><figcaption><p>A query with two groups of two rules each.</p></figcaption></figure>

There are two groups linked with AND, so records will only be found if they match both groups. The first group finds records which are databases and are also either ready or in development (multiple terms within a single rule are always joined by OR). The second group finds records which are either linked to the University of Oxford or have either manual or automated data curation. This could be summarised as:

((registry = database AND record status = (ready OR in development)) AND (data curation = (manual OR automated) OR organisations = University of Oxford))

Upon executing the search (use the "proceed" button in the bottom right) you will see a list of results with a summary of your search on the left:

![](https://isabelschoepsthiel-files.gitbook.io/~/files/v0/b/gitbook-x-prod.appspot.com/o/spaces%2F-Mcht5-9Lysnv_oQFJJh%2Fuploads%2FTZMpDVtFwZ5yFRhgjlEj%2FScreenshot%20from%202024-03-06%2013-12-23.png?alt=media\&token=bce93cee-523e-4994-bfc6-532c33644801)<br>

The download button will download a list of all results with the URLs on the FAIRsharing site, as described in the section for [simple search results](https://fairsharing.gitbook.io/fairsharing/how-to/search#search-results). <br>

## Editing Search Results

As mentioned above, it's quite possible to construct a search that has no results; the FAIRsharing system won't know if there will be no results until the query is run, so you may need to edit your query and run again until you get results matching what you expect. To do that, click the "edit advanced search" button at the top left. This will re-open the editing interface described above and, at this point, you can also add free text to a search box that will be searched in the same way as [simple search](https://fairsharing.gitbook.io/fairsharing/master).

Clicking "restart advanced search" will pop up a search interface with everything re-set to the default. Your previous search will not be cleared unless you commence a new one.&#x20;

## Saving Searches

If you are logged in, you can choose to save your search to your user profile; note that this saves your search filters/criteria, but does NOT save the search results. This would allow you to run the exact same search whenever you like, optionally downloading the search results each time so that you can compare your results over time. Further details are in our Saved Search [documentation and examples](https://fairsharing.gitbook.io/fairsharing/how-to/database-discovery#saving-searches).

## Further Developments

Advanced search is still undergoing development and new features and refinements will eventually be added, such as the ability to save your search results.&#x20;

Should you encounter any difficulty using it then please feel free to [contact us](mailto:contact@fairsharing.org).&#x20;
