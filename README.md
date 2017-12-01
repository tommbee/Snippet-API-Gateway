[![Build Status](https://travis-ci.org/tommbee/Snippet-API-Gateway.svg)](https://travis-ci.org/tommbee/Snippet-API-Gateway)
# Snippet API Gateway
A lightweight API gateway to handle your microservice requests.

Snippet allows you to handle all of your microservice requests via one URL. Any request body data or URL parameters are included in the proxied request.

## Getting started
Edit the routes.yml file in app/Config. First state the URL endpoint. Then define the microservice route, the method and the type of request.
```
'/posts':
  route: 'https://jsonplaceholder.typicode.com/posts'
  method: 'get'
  type: 'http'
```

Deploy using docker.

