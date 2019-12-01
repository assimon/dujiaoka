laravel-admin login-captch
======

Installation
First, install dependencies:

    composer require james.xue/login-captcha
 
Configuration
 In the extensions section of the config/admin.php file, add some configuration that belongs to this extension.
 
     'extensions' => [
         'login-captcha' => [
             // set to false if you want to disable this extension
             'enable' => true,
         ]
     ]
     
### 修改中文

    php artisan vendor:publish --tag=lang
    
### 输入框背景透明化

在config/admin.php 中添加 

	'background' => true,

### 注意事项
<div>
    <table border="0">
	  <tr>
	    <th>Version</th>
	    <th>Laravel-Admin Version</th>
	  </tr>
	  <tr>
	    <td>^1.7.1</td>
	    <td>< 1.6.10</td>
	  </tr>
	  <tr>
        <td>^1.8</td>
        <td>>= 1.6.10</td>
      </tr>
	</table>
</div> 
