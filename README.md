Hello :)

This is a webshop app called Aroma.

This app is built with Laravel and JavaScript, it uses HTML and CSS theme from colorlib.com and in admin area, it uses AdminLTE.

For payment gateway, it uses Stripe.

## Unauthenticated users can:
- see every product that has quantity >0 and are published
- put product in favourites or cart
- unauthenticated user can order by credit card or by cash on delivery

## Authenticated users can also:
- see their history of orders
- see status of their order (waiting for courier to pick up, in transit, etc)
- can download their order in PDF
- can change password and delete account

## In admin area, there are 5 types of admins:
1. Master admin who can:
- create other app workers
- create categories
- create coupons
- change app settings (address, phone, email, etc.)
- see log of other worker's activity: 
  - who changed product prices and quantity
  - who created product
  - who changed order (order is paid, user is contacted)
  - stripe errors

2. Orders Administrator who can:
- call users that have ordered
- approve order and send it to warehouse

3. Product Manager who can:
- create products 
- add prices 
- add quantities 
- publish products

4. Product Administrator who can:
- only create products without giving prices and quantities (this is for a person with more responsibility)

5. Warehouse manager who can:
- update status of order to in preparation, waiting for courier, in transit, returned
- update date when order was picked up by courier

All admins can see in dashboard chart of sale orders counts and orders totals: 
- today's orders
- yesterday's orders
- this month's orders
- last month's orders
- last year's orders by month


Thank you,
