#!/bin/bash
echo '\n\r'
echo 'test rate; expect ok'
echo '\n\r'
response=$(curl -s -w "\nHTTP Response Code: %{http_code}\n" "http://localhost:3897/rate")
echo "$response"
echo '\n\r'

echo '\n\r'
echo 'test subscribe; wrong email pattern'
echo '\n\r'
curl -i -X POST http://localhost:3897/subscribe -d "email=value1"
echo '\n\r'

echo '\n\r'
echo 'test subscribe; alrady added email (Must be added by default)'
echo '\n\r'
curl -i -X POST http://localhost:3897/subscribe -d "email=test3@mail.com"
echo '\n\r'

# add uniq email manual
echo '\n\r'
echo 'test subscribe; you must manually add unique email'
echo '\n\r'
curl -i -X POST http://localhost:3897/subscribe -d "email=uniq@mail.com"
echo '\n\r'
