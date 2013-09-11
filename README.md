kiilib_php
==========

Kii Cloud Library for PHP. This library provides APIs for Kii Cloud and data structures.

This library supports limited APIs of ones for other platforms like Android / iOS. 

Entities
========

KiiUser
-------
Represents Application user. User is authorized by 
- username and password
- email and password
- phone and password

KiiGroup
--------
Represents Group in Kii Cloud. Group consists of 
- Member : A list of KiiUser
- Name : The name of group
- Owner : Group owner

KiiBucket
---------
Represents Bucket in Kii Cloud. Bucket consists of 
- Owner : Bucket owner. Application / Group / User can be an owner of bucket. 
- Name : The name of bucket.

KiiObject
---------
Represents Object in Kii Cloud. The format is JSON with some headers. 

APIs
====

Application API
---------------
```
AppAPI __construct($context)
```
Initialize App API

```
KiiUser login($userIdentifier, $password)
```
Login Kii Cloud and set Access token to context. 

```
UserAPI userAPI()
```
Gets userAPI

```
BucketAPI bucketAPI()
```
Gets bucketAPI

```
ObjectAPI objectAPI()
```
Gets objectAPI

```
ACLAPI aclAPI()
```
Gets ACL API

User API
--------

Bucket API
----------

Object API
----------

ACL API
-------



