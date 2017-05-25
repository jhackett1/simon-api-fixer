Simon API Fixer
==============

This is a quick WP plugin to modify the JSON response for the users endpoint of the WP API on the UWSU staff intranet. It exposes additional Buddypress and WP core user fields in order to populate the team gallery widget over on UWSU.com.

Extra fields are exposed as an array ~~~~#jh_meta~~~~, which contains the following keys:

* Department
* Job title
* Roles
* Telephone extension
* Email
* Twitter handle
* Primary picture
* Alternate picture
* Fallback picture

Users who have authored no posts are also exposed (WP doesn't show these by default).

Contact smc@smoke.media with queries.
