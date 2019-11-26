# wp-pdf-inventory
*Generate a list of all of the PDFs in your WordPress media library*

This is a super-simple, quick-and-dirty tool for generating a list of PDFs. It was built for NC State's Great PDF Purge of 2019 for the IT Accessibility Office.

## What it does
- For a given URL for a WordPress website, query the REST API for media files with a MIME type of `application/pdf`.
- Display a table of up to 1,000 PDFs with the name, date uploaded, and URL of the file.
- Make you feel bad about the ridiculous number of PDFs your users have uploaded to WordPress. I mean really, no one needs this many PDFs.

## What it does not do
- Handle malformatted URLs, or run any kind of security checks on your user input. It's a quick-and-dirty tool meant for internal use, not something to be shared far and wide.
- Display more than 1,000 PDFs. If you have more than 1,000 PDFs in your WP media library, then (1) it should be easy to update this code to show them, and (2) you've got some serious problems and I'm sorry.

## Contributing
If you find this tool useful and you make improvements to it for your own use, please consider contributing a pull request! We're not planning on doing much active maintenance on this, but I'll gladly merge in useful enhancements.
