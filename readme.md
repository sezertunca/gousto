# How to run

Note: 
- Application built on a Mac and installation may slightly vary on a Windows PC.
- APIs can be tested using https://www.getpostman.com.
- Please put the data.csv file into the 'storage/app/public' folder.
- Follow the instructions below using Terminal app in the Mac.

## Running the Laravel Project
* Inside the 'project(gousto)/public' folder, run 'php -S localhost:3002' (Optinally, you can use the laravel documentation to learn how to run Laravel projects on https://laravel.com/docs/5.3)
• Run 'composer install'
• Rename .env.example file to .env
* .env file needs an APP_KEY to work.  Generate key using php artisan key:generate inside the app folder or use base64:s8FCWLx/dAF3hL3dSscGftSXxgd4pxnQw5KqK1o4+R0= by adding it to APP_KEY= in your .env file
(APP_KEY=base64:s8FCWLx/dAF3hL3dSscGftSXxgd4pxnQw5KqK1o4+R0=)
* Put the data.csv in 'storage/app/public'

Access the API routes using localhost:3002

To fetch all recipes
	http://localhost:3002/api/v1/recipes
To fetch a recipe by Id
	http://localhost:3002/api/v1/recipes/1
Fetch all recipes for a specific cuisine (should paginate)
	http://localhost:3002/api/v1/recipesForCuisine/italian
Rate an existing recipe between 1 and 5
	http://localhost:3002/api/v1/recipes/1/rate
Update an existing recipes
	http://localhost:3002/api/v1/recipes/1/update
Store a new recipe
	http://localhost:3002/api/v1/recipes/store

## Running tests
Inside the 'gousto' folder using Terminal app (Mac):
* Run 'phpunit'


Any problem email me at sezertunca@gmail.com


