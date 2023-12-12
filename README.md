# Xplor Inventory System

Create a RESTful API for an inventory management system using Laravel and Mysql.

## softwares Rewquired:
- PHP 8.1
- Laravel 10
- Mysql
- Composer

## Steps to Setup: 
- Install composer.
- Update MySQL db credentials in .env
- Run composer install in project root folder
- Run php artisan config:cache and php artisan migrate
- Run php artisan serve
- Can access the application using -

## Authorization:

update .env file XPLOR_API_TOKEN="your_auth_token" .

To Authenticate an API request, should provide API key in the `Authorization` header as `Bearer your_auth_token`.


### headers for all API's:

| Authorization | Bearer Token      | Description              |
| :------------ | :------------     | :------------------------- |
| `Token`       | `your_auth_token` | **Required**. Your API AUTH key |

| Request Header    |                   |                            |
| :---------------  | :------------     | :------------------------- |
| `Accept`          | `application/json`   | **Required**.              |


API List:

### Get all categories

```
  GET {{base_url}}/api/category
```

#### Response:

```javascript
{
    "data": [
        {
            "id": 1,
            "name": "Cat",
            "description": "test",
            "created_at": "2023-12-11T09:08:35.000000Z",
            "updated_at": "2023-12-11T09:08:35.000000Z"
        },
    ],
    "success": true
}
```
#### Get a category

```
  GET {{base_url}}/api/category/{{category_id}}
```
#### Request Params: Pass id.
```javascript
{
    {
            "id": 1,
            "name": "Cat",
            "description": "test",
            "created_at": "2023-12-11T09:08:35.000000Z",
            "updated_at": "2023-12-11T09:08:35.000000Z"
        },
    "success": true
}
```


#### Create a category

```
  POST {{base_url}}/api/category
```
#### Request Params: 
Name and Description
{
    "name": "Nails",
    "desc": "Update test"
}

#### Responses
```javascript
{
    "data": {
        "name": "Nails",
        "description": "update test",
        "updated_at": "2023-12-12T02:38:47.000000Z",
        "created_at": "2023-12-12T02:38:47.000000Z",
        "id":2
    },
    "success": true,
    "message": "Category created successfully"
}
```

#### Update a category

```
  PUT {{base_url}}/api/category/{{category_id}}
```
#### Request Params:
Pass id

#### Responses
```javascript
{
    "data": {
        "name": "Category name updated",
        "description": "demo desc",
        "updated_at": "2023-12-12T02:38:47.000000Z",
        "created_at": "2023-12-12T02:38:47.000000Z",
        "id": 2
    },
    "success": true,
    "message": "Category updated successfully"
}
```

#### Delete a category

```
  DELETE {{base_url}}/api/category/{{category_id}}
```
#### Request Params:
Pass id

#### Responses
```javascript
{
    "message": "Category deleted successfully",
    "success": true
}
```

# Item API:

### Get all Items

```
  GET {{base_url}}/api/item
```

#### Responses
List API returns a JSON response in the following format:

```javascript
{
    "data": [
        {
            "id": 1,
            "name": "Test category",
            "description": "Test description",
            "price": "200.00",
            "quantity": 501,
            "created_at": "2023-12-12 03:29:00",
            "updated_at": "2023-12-12 03:29:00",
            "categories": [
                {
                    "id": 2,
                    "name": "category 02",
                    "description": "desc"
                },
            ]
        },
    ],
    "success": true
}
```

#### Get an Item

```
  GET {{base_url}}/api/item/{{item_id}}
```
#### Request Params:
Pass id

```javascript
{
    "data": {
        "id": 29,
        "name": "item 2121",
        "description": "222",
        "price": "30.00",
        "quantity": 10,
        "categories": [
            {
                "id": 2,
                "name": "cat 02",
                "description": "desc"
            }
        ],
        "created_at": "2023-12-12 06:25:23",
        "updated_at": "2023-12-12 06:27:39"
    },
    "success": true
}
```

#### Create an Item

```
  POST {{base_url}}/api/item
```
#### Request Params:
{
    "name": "Nails",
    "desc": "Uodate test",
    "price": 20,
    "qty": 20,
    "cat_id" : [1,2]
}

#### Responses
```javascript
{
    "data": {
        "name": "item demo",
        "description": "222",
        "price": "200.00",
        "quantity": 20,
        "updated_at": "2023-12-12T06:25:23.000000Z",
        "created_at": "2023-12-12T06:25:23.000000Z",
        "id": 29
    },
    "success": true,
    "message": "Item created and Email sent successfully!"
}
```

#### Update an item

```
  PUT {{base_url}}/api/item/{{item_id}}
```
#### Request Params:
{
    "name": "Nails",
    "desc": "Update test",
    "price": 20,
    "qty": 20,
    "cat_id" : [1,2]
}

#### Responses
```javascript
{
    "data": {
        "id": 29,
        "name": "items update",
        "description": "222",
        "price": "30.00",
        "quantity": 10,
        "created_at": "2023-12-12T06:25:23.000000Z",
        "updated_at": "2023-12-12T06:27:39.000000Z"
    },
    "success": true,
    "message": "Item updated and Email sent successfully!"
}
```

#### Delete an item

```
  DELETE {{base_url}}/api/item/{{item_id}}
```
#### Request Params:
Pass id

#### Responses
```javascript
{
    "message": "Item deleted successfully",
    "success": true
}
```

