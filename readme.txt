=== XcooBee Document ===
Contributors: xcoobee
Tags: xcoobee, privacy, document, file, upload, security, gdpr, ccpa
Requires at least: 4.4.0
Tested up to: 5.2.2
Stable tag: 1.3.3
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Safe and secure CCPA / GDPR compliant file transfer with workflow for small and very large files.

== Description ==

Many times you have the need to accept and send files securely via your website. The standard upload/download pattern is cumbersome and tends to be insecure, especially when your WordPress is co-hosted with many other sites.
Now, add the new Privacy regulations (GDPR or CCPA) to this mix and you are guaranteed to have a headache on your hands.
Whether it is CAD drawings, contracts or job applications, you need an improved mechanism other than an openly accessible web server or email to securely manage the movement of documents.

The XcooBee Document Add-on handles these and many more document exchange scenarios while guaranteeing file delivery, security and proper privacy compliance. 
Since the file transfer is using the XcooBee network it guarantees full privacy and security and encryption at every step including the removal of all data traces shortly after documents have been delivered.

More specifically with this plugin you will be able to:
    - validate that only the designated type of document is accepted
    - accept additional processing data and messages
    - handle large file sizes not possible via email
    - start a custom workflow on the XcooBee network
    - design drop zones on your website to drop off any type of file
    - send documents to recipients securely
        

Through the XcooBee network:
    - start workflow with different tasks, such as cleanup, resize, validation, digital signature
    - drop of to cloud storage (Google Drive, OneDrive, Dropbox)
    - record acceptance, arrival, and receiving times of documents
    - get activity history
    - set account and transfer limits

The XcooBee Document Plug-in is an Add-on. It requires the [XcooBee For WordPress](https://wordpress.org/plugins/xcoobee/) plugin to work correctly. You will need to install it first.

== How to Use ==

To work with the document plugin you need to create file upload zones (dropzones) on your pages. You add these dropzones via shortcodes to your pages. 
You design the dropzone shortcode in the settings area of this plugin. The settings also is where you can check out all the short-code options and parameters.

=== Bee System Names ===

In order for the dropzone to be configured correctly you need to designate a XcooBee bee to take on the processing of the documents. A XcooBee bee is like a task manager, it manages the jobs assigned to it. You will need to use the bee-system name as assigned by the XcooBee system.

The easiest way to search for bee system-names is use the Search box in the plugin settings area.

In our example shortcodes we use the "transfer" bee which is responsible for directly delivering files to recipients.

You can [search XcooBee](https://app.xcoobee.net/user/beesDetail) for more bees and even create your own workflow with your own name assigned to your bee (job). You can find details for each bee including its system-name by looking at the [Bee Details screen](https://app.xcoobee.net/bee/transfer) and expanding the "Advanced Parameters". 

=== Sending Files and Documents ===

If you need to send files via XcooBee we expose a quick use function `xbee_send_file` for all your plugins and your PHP code. 
You can use it to send documents securely.
Please note that this will use points as appropriate under your registered API account.

== About XcooBee ==

XcooBee is a privacy-focused data exchange network with a mission to protect the digital rights and privacy of consumers and businesses alike.

XcooBee offers a number of plugins and add-ons for users to pick and choose the tools they need to improve privacy and GDPR compliance.

[XcooBee For WordPress](https://wordpress.org/plugins/xcoobee/) is our common plugin that you need to install in order to use other XcooBee WordPress add-ons. 
To get the most of the plugins and add-ons we recommend you obtain an API key. This can be obtained freely on the [XcooBee network](https://www.xcoobee.com) by upgrading to a developer account.

= Why XcooBee? =

The battle over privacy will be the new frontier in security. Small and medium businesses do not have time to make tools or manage complex software. XcooBee aims to simplify this and make powerful tools available to WordPress sites as well as their customers. Most of these are available for free.

We believe that people should have the power to decide what happens to their data and how it is shared. They should benefit from its exchange if they so choose. They should be empowered to make those decisions. In short they should have agency over their data.

This is not only a good vision, but with the advent of the GDPR, good business practice.

= How XcooBee works? =

We at XcooBee believe that privacy is not static and not the same for everybody.

We deliver tools, services, and techniques to allow individuals to control the exchange, distribution and management of their own information while allowing businesses fair use and compliance.

Tools we provide remove the complexity of compliance with GDPR when using WordPress. All this while improving the convenience and trust of the end-customers. A paid subscription to XcooBee is optional but recommended if you wish to use all the features.

= Built with developers in mind =

We support XcooBee and all its add-ons with comprehensive, easily-accessible documentation. With our docs, you’ll learn how to easily use and even extend our plugin.
[XcooBee Documentation](https://www.xcoobee.com/docs)

= Add-ons =

WordPress.org is home to some amazing extensions for this plugin, including:

- [XcooBee For WordPress](https://wordpress.org/plugins/xcoobee/) - this is the base plugin required for all add-ons
- [XcooBee Cookie](https://wordpress.org/plugins/xcoobee-cookie/)
- [XcooBee Document](https://wordpress.org/plugins/xcoobee-document/)
- [XcooBee Data Consent](https://wordpress.org/plugins/xcoobee-forms/)
- [XcooBee Subject Access Request](https://wordpress.org/plugins/xcoobee-sar/)

== Installation ==

= Minimum Requirements =

* PHP version 5.6.0 or greater (PHP 7.2 or greater is recommended)

= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don’t need to leave your web browser. To do an automatic install of XcooBee, log in to your WordPress dashboard, navigate to the Plugins menu and click Add New.

In the search field type “XcooBee Document” and click Search Plugins. Once you’ve found our plugin you can view details about it such as the point release, rating and description. Most importantly of course, you can install it by simply clicking “Install Now”.

= Manual installation =

The manual installation method involves downloading our plugin and uploading it to your webserver via your favorite FTP application. The WordPress codex contains [instructions on how to do this here](https://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

= Updating =

Automatic updates should work like a charm; as always though, ensure you backup your site just in case.

== Frequently Asked Questions ==

= Where can I find documentation for XcooBee? =

- [XcooBee Concepts](https://www.xcoobee.com/docs/xcoobee-concepts)
- [XcooBee User Levels](https://www.xcoobee.com/docs/xcoobee-user-levels/)
- [Developer Documentation](https://www.xcoobee.com/docs/developer-documentation)
- [Bee Documentation](https://www.xcoobee.com/docs/bee-documentation)
- [XcooBee Terms of Service](https://www.xcoobee.com/about/terms-of-service/)
- [XcooBee Privacy Policy](https://www.xcoobee.com/about/privacy/)


= Where can I get support or talk to other users? =

If you need any help with XcooBee, please use our [contact us](https://www.xcoobee.com/contactus) page or via the Feedback button in XcooBee application to get in touch with us.

== Screenshots ==

1. The document settings panel.
2. Shortcodes and helper functions.
3. Dropzone area.

== Changelog ==

See CHANGELOG file in project