# m2-routing-module
M2 Router Module for Magento 2 Certification

This module has been createdd to create new router in Magento 2. The following are the standard routes in Magento 2 out of the box

| Route Name  | Description |
| ------------- | ------------- |
| robots  | Matches request to the robots.txt file  |
| urlrewrite  | Matches requests with URL defined in the database
| standard | The standard router
| cms | Matches requests for CMS pages
| default | The default router

Install this module and try m2.baseurl.com/learning to see the results

We have created our new router by matching the keyword "learning" but you can put your own logic to do the routing matching.

This module has been created to answer the following Magento 2 question from official Magento study guide

2.3 Demonstrate ability to customize request routing
Describe request routing and flow in Magento. When is it necessary to create a new router or to customize existing routers?

Question 1

A merchant asks you to create a module that is able to process URLs with a custom structure that can contain any combination of a product type code, a partial name, and a 4-digit year in any order.
The request path will look like this: /product/:type-code/:name-part/:year
Which layer in the Magento request processing flow is suited for this kind of customization? 

A. Front controller
B. Router
C. Action controller
D. HTTP Response 

Answer : B
