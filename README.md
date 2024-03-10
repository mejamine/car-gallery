This is a Symfony project sample which is a car gallery with an authentification interface with two type of users ("admin" , "user")
download Xamp, clone this project in your local machine (in c: -> xamp -> htdocs ) and  configure your data base in the project files (.env)
like this (' DATABASE_URL="mysql://root@127.0.0.1:3306/MyCarGallery" ')
open your XAMP and run apashe and mysql
open terminal in your visual studio code or any editor of code and execute this line (' php bin/console doctrine:schema:update --force ') or these two lines :
1- php bin/console make:migration
2- php bin/console doctrine:migrations:migrate
you'll find that the database and the tables are automaticly created so 
//adding brands to the data base:

enter your phpMyAdmin interface -> the data base of the project -> the marque table ->SQL 
and run the following request:

INSERT INTO `marque` (`id`, `name`, `logo`) VALUES
(NULL, 'Bentley', 'Bentley.png'),
(NULL, 'BMW', 'BMW.png'),
(NULL, 'Dodge', 'Dodge.png'),
(NULL, 'Ferrari', 'Ferrari.png'),
(NULL, 'Ford', 'Ford.png'),
(NULL, 'Jaguar', 'Jaguar.png'),
(NULL, 'Lamborghini', 'Lamborghini.png'),
(NULL, 'Maserati', 'Maserati.png'),
(NULL, 'Mercedes', 'Mercedes.png'),
(NULL, 'Rolls Royce', 'RollsRoyce.png'),
(NULL, 'Toyota', 'Toyota.png'),
(NULL, 'Volkswagen', 'Volkswagen.png'),
(NULL, 'Porshe', 'porshe.png'),
(NULL, 'Aston Martin', 'AstonMartin.png');

//adding cars to the database

after you run the previous request in your phpMyAdmin sql bar of the marque table go to the car table -> to the sql bar an run these requests:

INSERT INTO `car` (`id`, `name`, `image`, `description`, `marque_id`) VALUES (NULL, 'Bentley 4.5 Litres', '4.5litre.jpg', '', '1'),(NULL, 'Bentley S1', 'S1.jpg', '', '1'),(NULL, 'Bentley Continental SC', 'continentalSC.jpg', '', '1');
INSERT INTO `car` (`id`, `name`, `image`, `description`, `marque_id`) VALUES (NULL, 'BMW 335', '335.jpg', '', '2'),(NULL, 'BMW 503', '503.jpg', '', '2'),(NULL, 'BMW 328', '328.jpg', '', '2');
INSERT INTO `car` (`id`, `name`, `image`, `description`, `marque_id`) VALUES (NULL, 'Dodge Charger', 'charger.jpg', '', '3'),(NULL, 'Dodge Cornet', 'cornet.jpg', '', '3'),(NULL, 'Dodge Custom 4 Door', 'custom4door.jpg', '', '3');
INSERT INTO `car` (`id`, `name`, `image`, `description`, `marque_id`) VALUES (NULL, 'Ferrari 166 Inter Touring', '166interTouring.jpg', '', '4'),(NULL, 'Ferrari 250GT SUB', '150GTsub', '', '4'),(NULL, 'Ferrari 250GTO', '250GTO.jpg', '', '4');
INSERT INTO `car` (`id`, `name`, `image`, `description`, `marque_id`) VALUES (NULL, 'Ford Capri', 'capri.jpg', '', '5'),(NULL, 'Ford Mustang 1967', 'mustang1967.jpg', '', '5'),(NULL, 'Ford Torino GT', 'torinoGT.jpg', '', '5');
INSERT INTO `car` (`id`, `name`, `image`, `description`, `marque_id`) VALUES (NULL, 'Jaguar XJ6', 'XJ6.jpg', '', '6'),(NULL, 'Jaguar Mark V', 'markV.jpg', '', '6'),(NULL, 'Jaguar XK 120C', 'XK120C', '', '6');
INSERT INTO `car` (`id`, `name`, `image`, `description`, `marque_id`) VALUES (NULL, 'Lamborghini Espada', 'espada.jpg', '', '7'),(NULL, 'Lamborghini Urraco', 'urraco.jpg', '', '7'),(NULL, 'Lamborghini Miura', 'miura.jpg', '', '7');
INSERT INTO `car` (`id`, `name`, `image`, `description`, `marque_id`) VALUES (NULL, 'Maserati 450 S', '450S.jpg', '', '8'),(NULL, 'Maserati Ghibli', 'ghibli.jpg', '', '8'),(NULL, 'Maserati Merak', 'merak.jpg', '', '8');
INSERT INTO `car` (`id`, `name`, `image`, `description`, `marque_id`) VALUES (NULL, 'Mercedes 540 K', '540k.jpg', '', '9'),(NULL, 'Mercedes 300D', '300d.jpg', '', '9'),(NULL, 'Mercedes 300SL', '300sl.jpg', '', '9');
INSERT INTO `car` (`id`, `name`, `image`, `description`, `marque_id`) VALUES (NULL, 'Rolls Royce Phantom 3', 'phantom3.jpg', '', '10'),(NULL, 'Rolls Royce Silver Cloud II 1960', 'silverCloudII1960.jpg', '', '10'),(NULL, 'Rolls Royce Phantom 1925', 'phantom1925.jpg', '', '10');
INSERT INTO `car` (`id`, `name`, `image`, `description`, `marque_id`) VALUES (NULL, 'Toyota AA', 'AA.jpg', '', '11'),(NULL, 'Toyota 200 GT', '200GT.jpg', '', '11'),(NULL, 'Toyota Corolla 1979', 'corolla1979.jpg', '', '11');
INSERT INTO `car` (`id`, `name`, `image`, `description`, `marque_id`) VALUES (NULL, 'Volkswagen VW Type 3', 'VWtype3.jpg', '', '12'),(NULL, 'Volkswagen Beetle 1967', 'beetle1967.jpg', '', '12'),(NULL, 'Volkswagen Cabriolet 1989', 'cabriolet1989.jpg', '', '12');
INSERT INTO `car` (`id`, `name`, `image`, `description`, `marque_id`) VALUES (NULL, 'Porshe 911 1980', '911-1980.jpg', '', '13'),(NULL, 'Porshe 356 1950', '356-1950.jpg', '', '13'),(NULL, 'Porshe 356 SC 1965', '356sc-1965.jpg', '', '13');
INSERT INTO `car` (`id`, `name`, `image`, `description`, `marque_id`) VALUES (NULL, 'Aston Martin DB4', 'DB4.jpg', '', '14'),(NULL, 'Aston Martin PBR1', 'PBR1.jpg', '', '14'),(NULL, 'Aston Martin Lagonda Seri I', 'lagonda1.jpg', '', '14');

now you have your database full you can now see them on the application


go to your browser and open this link (' localhost/car-gallery/public/index.php ')
open the sign up interface and add a user
this user that you added is admin so go to the code (src -> Entity -> user.php)  and change this line (" $this->roles = ['ROLE_ADMIN'];") to (" $this->roles = ['ROLE_USER'];")
then add an other user into the signup interface
this user now is a normal user
try to login with bothe accounts and try the crud created in this project (accessibale by admin only) (user can only see the cars , login , logout )
if there's any changes you suggest i'm open to it 
