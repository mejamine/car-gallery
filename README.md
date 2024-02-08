This is a Symfony project sample which is a car gallery with an authentification interface with two type of users ("admin" , "user")
download Xamp, clone this project in your local machine (in c: -> xamp -> htdocs ) and  configure your data base in the project files (.env)
like this (' DATABASE_URL="mysql://root@127.0.0.1:3306/MyCarGallery" ')
open your XAMP and run apashe and mysql
open terminal in your visual studio code or any editor of code and execute this line (' php bin/console doctrine:schema:update --force ') or these two lines :
1- php bin/console make:migration
2- php bin/console doctrine:migrations:migrate
go to your browser and open this link (' localhost/car-gallery/public/index.php ')
open the sign up interface and add a user
this user that you added is admin so go to the code (src -> Entity -> user.php)  and change this line (" $this->roles = ['ROLE_ADMIN'];") to (" $this->roles = ['ROLE_USER'];")
then add an other user into the signup interface
this user now is a normal user
try to login with bothe accounts and try the crud created in this project (accessibale by admin only) (user can only see the cars , login , logout )
if there's any changes you suggest i'm open to it 
