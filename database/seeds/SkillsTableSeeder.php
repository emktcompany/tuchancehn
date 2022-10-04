<?php

use Illuminate\Database\Seeder;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills = [
            "Web Design", "WordPress", "HTML", "CSS", "Logo Design",
            "Web Development", "Photoshop", "Responsive Design", "PHP",
            "Brand Identity", "Graphic", "WordPress Maintenance",
            "Illustrator", "WordPress Theme", "JavaScript", "jQuery",
            "User Interface", "User Experience", "Bootstrap", "Online Store",
            "3D Modeling & CAD", "Adaptive", "After Effects", "Animation",
            "Art Direction", "Banner Ad", "Blog Design", "Book Cover",
            "Book Interior", "Brand Identity", "Brochure", "Business Card",
            "Caricature", "Catalogue", "Creative Direction", "eBook Design",
            "Email Opt-In", "Email Template", "Favicon", "Forum", "GIMP",
            "Graphic", "Icon", "Illustration", "Illustrator", "InDesign",
            "Infographic", "Inkscape", "Interaction", "Landing Page",
            "Letterhead", "Lettering", "Logo Design", "Motion", "Packaging",
            "Pattern", "PDF", "Photography", "Photoshop", "Popup", "Poster",
            "Print Design", "Responsive Design", "Sales Page", "Signage",
            "Sketch", "Social Media Graphic", "Squeeze Page", "T-Shirt",
            "Type", "Typography", "User Experience", "User Interface",
            "Vector", "Video Production", "Web Design", "AJAX",
            "Amazon Web Services", "Android App", "AngularJS", "Apache",
            "Appcelerator", "ASP.NET", "AWeber", "BackboneJS", "Back-End",
            "Bigcommerce", "BlackBerry", "Bookings", "Bootstrap", "Bower",
            "BuddyPress", "C", "C#", "C++", "CakePHP", "CMS", "CodeIgniter",
            "CoffeeScript", "Comparison App", "Craft", "CSS", "Debian",
            "Django", "Docker", "Doctrine", "Drupal", "eLearning", "Erlang",
            "ExpressionEngine", "ExpressJS", "File Sharing", "Flash", "Flask",
            "Foundation", "Front-End", "Full Stack", "Genesis Framework",
            "Ghost", "Git", "Go", "Grunt", "Gulp", "Heroku", "HTML", "HubSpot",
            "Infusionsoft", "iOS", "iPhone App", "Isotope", "J2EE", "Java",
            "JavaScript", "Jekyll", "Joomla", "jQuery", "KloudStores",
            "KrakenJS", "Laravel", "Less", "Linux", "Magento", "MailChimp",
            "Marketplace", "Membership Website", "Meteor", "Mobile App",
            "MongoDB", "MVC", "MySQL", ".NET", "Network Administration",
            "Nginx", "nodeJS", "Node Webkit", "nopCommerce",
            "One-Page Website", "Online Store", "Online Tool", "OpenCart",
            "OptimizePress", "Oracle", "Page Speed", "PayPal", "PhoneGap",
            "PHP", "Portal", "PostgreSQL", "PrestaShop", "Python", "React",
            "Redis", "REST API", "RSS", "Ruby", "Ruby on Rails", "SaaS",
            "Sass", "Search Tool", "Sensei", "SEO", "Server Administration",
            "SharePoint", "Shopify", "Social Network", "Software",
            "SQL Server", "Squarespace", "Stripe", "Swift", "Symfony",
            "SysAdmin", "Thesis Theme", "Tracking App", "Travis", "Twilio",
            "Ubuntu", "Umbraco", "Unix", "Visual Basic", "VueJS", "WatchKit",
            "WCF", "WebAPI", "Web App", "Web Development", "Web Security",
            "WebSocket", "Windows Phone", "Wix", "WooCommerce", "WordPress",
            "WordPress Maintenance", "WordPress Plugin", "WordPress Theme",
            "XML", "X Theme", "Yii", "Zend Framework",
        ];

        foreach ($skills as $name) {
            App\TuChance\Models\Skill::create(compact('name'));
        }
    }
}
