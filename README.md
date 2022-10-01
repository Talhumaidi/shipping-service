# Steps to run the code:

`NOTE:` Please make sure that the ports `3306` and `8000` are not used.

1 - install `git`

2 - run `git clone https://github.com/Talhumaidi/shipping-service.git`

3 - cd `/path/to/shipping-service`

4 - run this command `cp .env.example .env`

5 - modify the `DB` environment variables in the `.env` file:

`DB_CONNECTION=mysql`\
`DB_HOST=db`\
`DB_PORT=3306`\
`DB_DATABASE=shipping_service`\
`DB_USERNAME=root`\
`DB_PASSWORD=root`

6 - Install `docker` & `docker-compose` on your machine.

7 - run `docker-compose build`

8 - run `docker-composer up -d`

9 - run `docker ps` and get the `main` container id

**please wait for 1 minute at least before doing these two steps**

10 - run `docker exec -it {main_container_id} /bin/sh`

11 - run `php artisan migrate:fresh --seed`

Now our database is ready and the application is hosted on `0.0.0.0:8000`

**APIs**
----

**1 - creating a shipment:**

* **URL**

  `/api/shipmpent`

* **Method:**

  `POST`

* **Data Params**

  **Required:**

  `carrier_id=[required|string|in:fedex_air,fedex_groud,ups_express,ups_2_day]`\
  `width=[required|numeric|max:30.48]` =>  Unit of measurement is centimeters.\
  `length=[required|numeric|max:45.72]` => Unit of measurement is centimeters.\
  `height=[required|numeric|max:20.32]` => Unit of measurement is centimeters.

* **Sample Success Response:**

    * **Code:** 201
      **Content:** `{
      "message": "Your shipment request has been created successfully!",
      "data": {
      "uuid": "3b90e925-8b95-4406-bf64-19c39fc7c80e"
      }
      }`

* **Sample Error Responses:**
    * **Code:** 422
      **Content:** `{
      "message": "The given data was invalid.",
      "errors": {
      "carrier_id": [
      "The selected carrier id is invalid."
      ]
      }
      }`

    * **Code:** 422
      **Content:** `{
      "message": "The given data was invalid.",
      "errors": {
      "width": [
      "The width may not be greater than 30.48 cm"
      ],
      "length": [
      "The length may not be greater than 45.72 cm"
      ]
      }
      }`

* **TODOs:**
  1 - Accept a new parameter `dimenstions_unit_of_measurement` and make the necessary conversions in the shipping service.

  2 - Accept the source & destination of the package  
