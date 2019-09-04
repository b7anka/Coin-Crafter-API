<h1><strong>Coin Crafter Api</strong></h1>

<p>This is the api and landing page that powers and keeps updated the coin crafter mobile application for both IOS and android versions</p>

<p>This application is made using the awesome php framework Laravel and before you can use it you need to change some settings:</p>

<ol>
    <li>Modify the information on the .env file in the project's root directory</li>
    <li>Run the following commands on the terminal:
        <p>composer dumpautoload</p>
        <p>php artisan config:cache</p>
        <p>php artisan route:cache</p>
        <p>php artisan migrate</p>
    </li>
    <li>Get an access key from data.fixer.io website</li>
    <li>Check the file inside cronJobs folder and follow instructions to modify it accordingly</li>
     <li>Check the file getImages.php inside public folder and follow instructions to modify it accordingly</li>
</ol>

<p>After you've done everything above just open a terminal inside your project's folder and run the following command:</p>
<ul>
    <li>php artisan serve</li>
</ul>
<p>If everything went well you should be running the app now. Fire the browser of your choice and access the url given in the terminal</p>
