kiilib_php
==========

Kii Cloud Library for PHP. This library provides APIs for Kii Cloud and data structures.

This library supports limited APIs of ones for other platforms like Android / iOS. 

PHP用Kii Cloudライブラリです。Kii Cloudに対するAPIと、データモデルを提供します。

このライブラリの位置づけは、Android/iOS用SDKのサブセットです。

Getting started
===============

This library will work on PHP 7.1+ and HTTP_Request2. Please install PEAR/HTTP_Request2


APIs
====

Please go to https://github.com/fkmhrk/kiilib_php/wiki/References

https://github.com/fkmhrk/kiilib_php/wiki/References に書いています。

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

KiiTopic
---------
Represents Topic in Kii Cloud. Topic consists of 
- Owner : Topic owner. Application / Group / User can be an owner of topic. 
- Name : The name of topic.





