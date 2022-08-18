 # Cockpit V1 CMS Vercel Deploys Addon

This addon provides integration with vercel deploys mechanism, leveraging the Vercel REST API to retrieve list of latest deploys and build hooks to trigger a new deploy. The addon can be useful when combining Cockpit CMS with an static site generator hosted on Vercel, so changes on contents can be deployed easily in seconds.

## Installation

1. Confirm that you have Cockpit CMS (Next branch) installed and working.
2. Download zip and extract to 'your-cockpit-docroot/addons' (e.g. cockpitcms/addons/Vercel, the addon folder name must be Vercel)
3. Confirm that the Vercel deploys icon appears on the top right modules menu.

## Configuration

1. Ensure that from your Vercel account you have an access token and a build hook url.
2. Edit Cockpit config/config.yaml and add a new entry for netlify like below:

```yaml
vercel:
  build_hook_url: https://api.vercel.com/v1/integrations/deploy/<hook_id>
  api_url: https://api.vercel.com/v6/deployments
  projectid: <project-id>
  token: <token>
```


There are just one permissions:

- **manage.view** - provides access to the Vercel deploy list


Copyright 2022 christian under the MIT license.