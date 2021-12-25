

## KosAPP
KosAPP is a web based application where Kos Owner can be promote their properties to potential tenants. Tenants can be ask room availability using credit points. This app using Laravel Framework as API backend. Please refers to below documentation:

* [System Requirements](#system-requirements)
* [Installation](#installation)
* [User Management](#user-management)
* [Log In](#login)
* [Kos Management](#kos-management)
* [Kos ShowCase](#kos-showcase)
* [Credit Recharge](#credit-recharge)
* [API Reference](#api-reference)

***

## system-requirements

Please make sure your environments fit with below requirements
1. PHP 7.4
2. MySQL / MariaDB 
3. Laravel 8
4. Composer
5. Postman

***

## installation

Please following this steps to complete the installation
1. Clone from repo https://github.com/yodhaanoraga/kosapp.
2. Create database, i.e. kosappdb.
3. Set database credential at .env file.
4. Execute migration. Here is the command "php artisan migrate".
5. Execute "php artisan serve".
6. Additional, you need to set crontab on your system. First, execute command "php artisan schedule:run". Then, save this routine command at your cron "* * * * * /usr/bin/php7.4 /your-app-installed-path/artisan schedule:run >> /dev/null 2>&1".
7. The apps is ready. You can access at URL http://127.0.0.:8000/api (ip address and protocol can be replace as domain name, depend on your environment setup).

***

## user-management

In this app, have 5 kind user type, such as
1. **Superadmin**. Does not have credit. Can be see all datas.
2. **Admin**. Same as Superadmin.
3. **Owner (Kos owner) User**. Does not have credit. Can be create, update, delete kos. Only can see its own Kos list.
4. **Regular User**. Will have 20 points credit. Will reduced 5 points after ask availability. Will added 20 points again every month.
5. **Premium User**. Will have 40 points credit. Will reduced 5 points after ask availability. Will added 40 points again every month.

In the begining, This app does not have any user. You must do register first.

***

## login

Some features are free to access, such as searching kos, see kos details. But for there is more features like create kos; see all submited kos; update kos; delete kos by kos owner, and asking room availability by (regular/premium) users are requires athentication.

***

## kos-management

Kos management are presented to kos owner. Due kos owner need to doing post their properties itself. Here is presented features
1. Create kos (1 or more)
2. See all submited kos list by owner
3. Update kos data
4. Delete kos
5. See all asked availability respectively by its kos list.

***

## kos-showcase

Kos showcase presented publicly. So all people can be see all kos no matter who the owner. User can see all kos, or may be searching kos by define keyword. Keyword can be relate to kos name or price or location/city.

If user interesting to specified kos, so user need to login first for ask room availability. Regular and Premium user have particular credit point. And when user has asked room availability, their credit will be reduced 5 points. If user don't have remaining credit, they cannot be ask availability.

***

## credit-recharge

The good news is, in every begining month, all Regular and Premium users will be recharge their credit. 20 points for Regular users and 40 points for Premium users.

***

## api-reference

Please refers to below API reference

### Register

https://example.domain/api/register
Method POST

**Request Params**
- name : mandatory, string, max 255
- email : mandatory, string, max 255
- password : mandatory, string, min 8
- user_type : mandatory, integer (3 = Owner, 4 = Regular, 5 Premium)

**Request example**
```json
{
    "name": "Lutfi Yusofa",
    "email": "lutfi@yusofa.com",
    "password": "jam3sb0nd",
    "user_type": "3",
}
```

**Response example**
```json
{
    "data": {
        "name": "Lutfi Yusofa",
        "email": "lutfi@yusofa.com",
        "user_type": "3",
        "credit": 0,
        "updated_at": "2021-12-25T10:59:59.000000Z",
        "created_at": "2021-12-25T10:59:59.000000Z",
        "id": 5
    },
    "access_token": "8|csbWZ2br3KA29WMg4JJlx3rc3v1gP0BOQJUFNqB0",
    "token_type": "Bearer"
}
```

### Log In

https://example.domain/api/login
Method POST

**Request Params**
- email : mandatory, string, max 255
- password : mandatory, string, min 8

**Request example**
```json
{
    "email": "lutfi@yusofa.com",
    "password": "jam3sb0nd",
}
```

**Response example**
```json
{
    "message": "Hi Lutfi Yusofa, welcome to home",
    "access_token": "9|UlohS6hn8hJ9jhafJQZjblyG24eSD0F24bVfcIvS",
    "token_type": "Bearer"
}
```

### Kos Owner - See Their Own Kos List

https://example.domain/api/property
Method GET

**Request Params**
- token : mandatory, string, bearer token type

**Request example**
```json
{
    "token": "9|UlohS6hn8hJ9jhafJQZjblyG24eSD0F24bVfcIvS",
}
```

**Response example**
```json
{
    "success": true,
    "message": "Property fetched",
    "data": [
        {
            "id": 11,
            "owner_id": 2,
            "name": "kos putri 11",
            "description": "kos putri 11",
            "location": "KarangPloso regency 2",
            "city": "Malang",
            "price": "1000000.00",
            "amenities": "free parking, breakfast every day, free wi-fi, security 24/7",
            "created_at": "2021-12-24T11:40:27.000000Z",
            "updated_at": "2021-12-24T11:40:27.000000Z"
        },
        {
            "id": 10,
            "owner_id": 2,
            "name": "kos putra 10",
            "description": "kos putra 10",
            "location": "KarangPloso regency 20",
            "city": "Malang",
            "price": "1000000.00",
            "amenities": "free parking, breakfast every day, free wi-fi",
            "created_at": "2021-12-24T11:32:56.000000Z",
            "updated_at": "2021-12-24T11:32:56.000000Z"
        },
        {
            "id": 5,
            "owner_id": 2,
            "name": "kos putri 11",
            "description": "kos putri 11",
            "location": "KarangPloso regency 2",
            "city": "Malang",
            "price": "1000000.00",
            "amenities": "free parking, breakfast every day, free wi-fi",
            "created_at": "2021-12-24T11:25:57.000000Z",
            "updated_at": "2021-12-24T11:25:57.000000Z"
        },
        {
            "id": 4,
            "owner_id": 2,
            "name": "kos putra 10",
            "description": "kos putra 10",
            "location": "KarangPloso regency 20",
            "city": "Malang",
            "price": "1000000.00",
            "amenities": "free parking, breakfast every day, free wi-fi",
            "created_at": "2021-12-24T11:24:49.000000Z",
            "updated_at": "2021-12-24T11:24:49.000000Z"
        },
    ]
}
```

### Kos Owner - Create Kos

https://example.domain/api/property
Method POST

**Request Params**
- token : mandatory, string, bearer token type
- name : mandatory, string, max 255
- description : mandatory, text
- location : mandatory, text
- city : mandatory, string, max 255
- amenities : optional, text

**Request example**
```json
{
    "token": "9|UlohS6hn8hJ9jhafJQZjblyG24eSD0F24bVfcIvS",
    "name": "kos exclusive",
    "description": "Kos exclusive available for weekly rent.",
    "location": "jalan sumatera no 34 lowokwaru",
    "city": "malang",
    "price": "1000000",
    "amenities": "parking, free breakfast, security 24/7",
}
```

**Response example**
```json
{
    "success": true,
    "message": "Property created successfully",
    "data": {
        "id": 13,
        "owner_id": 2,
        "name": "kos exclusive",
        "description": "Kos exclusive available for weekly rent.",
        "location": "jalan sumatera no 34 lowokwaru",
        "city": "malang",
        "price": "1000000",
        "amenities": "parking, free breakfast, security 24/7",
        "created_at": "2021-12-25T11:21:09.000000Z",
        "updated_at": "2021-12-25T11:21:09.000000Z"
    }
}
```

### Kos Owner - Update Kos

https://example.domain/api/property/{property_id}
Method PUT/PATCH

**Request Params**
- token : mandatory, string, bearer token type
- name : mandatory, string, max 255
- description : mandatory, text
- location : mandatory, text
- city : mandatory, string, max 255
- amenities : optional, text

**Request example**
```json
{
    "token": "9|UlohS6hn8hJ9jhafJQZjblyG24eSD0F24bVfcIvS",
    "name": "kos exclusive edited",
    "description": "Kos exclusive available for weekly rent. edited",
    "location": "jalan sumatera no 34 lowokwaru",
    "city": "malang",
    "price": "11000000",
    "amenities": "parking, free breakfast, security 24/7",
}
```

**Response example**
```json
{
    "success": true,
    "message": "Property updated successfully",
    "data": {
        "id": 13,
        "owner_id": 2,
        "name": "kos exclusive edited",
        "description": "Kos exclusive available for weekly rent. edited",
        "location": "jalan sumatera no 34 lowokwaru",
        "city": "malang",
        "price": "11000000",
        "amenities": "parking, free breakfast, security 24/7",
        "created_at": "2021-12-25T11:21:09.000000Z",
        "updated_at": "2021-12-25T11:27:58.000000Z"
    }
}
```

### Kos Owner - Delete Kos

https://example.domain/api/property/{property_id}
Method DELETE

**Request Params**
- token : mandatory, string, bearer token type

**Request example**
```json
{
    "token": "9|UlohS6hn8hJ9jhafJQZjblyG24eSD0F24bVfcIvS",
}
```

**Response example**
```json
{
    "success": true,
    "message": "Property deleted successfully"
}
```

### Public - Search Kos

https://example.domain/api/search
Method GET

**Request Params**
- keyword : optional, string

**Request example**
```json
{
    "keyword": "malang",
}
```

**Response example**
```json
{
    "success": true,
    "message": "Property fetched",
    "data": [
        {
            "id": 1,
            "owner_id": 2,
            "name": "Kos putra",
            "description": "Kos putra available for weekly rent. edited",
            "location": "jalan munggur barat no 57",
            "city": "malang",
            "price": "800000.00",
            "amenities": "parking, free breakfast, security 24/7",
            "created_at": "2021-12-24T10:32:15.000000Z",
            "updated_at": "2021-12-24T10:32:15.000000Z"
        }
    ]
}
```

### (Regular/Premium) User - Ask Room Availability

https://example.domain/api/askavailability
Method POST

**Request Params**
- token : mandatory, string, bearer token type
- property_id : mandatory, numeric
- start_period : mandatory, date (YYYY-MM-DD)

**Request example**
```json
{
    "token": "9|UlohS6hn8hJ9jhafJQZjblyG24eSD0F24bVfcIvS",
    "property_id": "13",
    "start_period": "2022-01-03",
}
```

**Response example**
```json
{
    "success": true,
    "message": "Ask availability created successfully. Your credit reduced 5 points. Your remaining credit = 15",
    "data": {
        "id": 2,
        "user_id": 3,
        "property_id": "13",
        "is_available": 0,
        "start_period": "2021-01-02",
        "created_at": "2021-12-25T11:52:16.000000Z",
        "updated_at": "2021-12-25T11:52:16.000000Z"
    }
}
```

### Public - See Kos Detail

https://example.domain/api/detail/{property_id}
Method GET

**Request Params Does Not Necessary**

**Response example**
```json
{
    "success": true,
    "message": "Property found",
    "data": {
        "id": 13,
        "owner_id": 2,
        "name": "kos exclusive edited",
        "description": "Kos exclusive available for weekly rent. edited",
        "location": "jalan sumatera no 34 lowokwaru",
        "city": "malang",
        "price": "11000000.00",
        "amenities": "parking, free breakfast, security 24/7",
        "created_at": "2021-12-25T11:21:09.000000Z",
        "updated_at": "2021-12-25T11:30:35.000000Z"
    }
}
```


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
