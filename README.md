<h1>Phinx Core</h1> 

<h2>Installation Steps</h2>

1) step 1
```
git clone https://github.com/Neamix/PhinxCore.git
```

2) step 2 

<ul>
    <li>Create mysql database</li>
    <li>Import route.sql (you will find it in root)</li>
</ul>

3) Step 3

<ul>
    <li>Create .env</li>
</ul>

4) Step 4

    ```
    composer install
    php artisan migrate
    php artisan db:seed
    php artisan storage:link
    ```
    
<h2>Setup</h2>

In setup page you can add the main information of the website and they can be retrive by using laravel service container

to start to use it create in public/storage system file and inside it add large,medium,small folders

<h3>Website Seo Title</h3>
Retrive it by

```
<title> {{ app()->make('setup',['type' => 'website title'])[0]; }} -  Adminpanal </title>
```
by default you will get  Website Seo Title, Website Seo Description, Website Footer Description,header logo , footer logo ,fav logo but u can add another field by simple add the input and give a name to it then add validation to it in SetupRequest and add it's insertion in setup model like that

in setup/index

```
  <div class="form-group">
                <label>new field</label>
                <textarea class="form-control" placeholder="Website Footer Description" name="website_footer_description_en">{{app()->make('setup',['type' => 'website footer description english'])[0]}}</textarea>
                <p class="error error_website_footer_description"></p>
            </div>
```

```
if ( $request->website_description )  {

            self::updateOrCreate(
                ['type' => 'new field'],
                [
                    'type'  => 'new field val',
                    'value' => $request->field_name
                ]
            );

        }

```

and after that you will be able to retrive it by using this command

```
{{ app()->make('setup',['type' => 'new field'])[0]; }}
```

<h2>Helpers</h2>
    
you can create a new helper file in app/http/Helpers after create it you need to require it in App\Http\Helpers\Kernal.php


<h2>Create Crud</h2>

```
php artisan phinx:crud Post
```

after you hit that command he will ask you for type and icon you can get icons from fontawesome version 4.7 or you can add in header layout higher version and use it 

go to admin/post/index.blade.php added your structure in 

```div.append-container```

and go to admin/post/upsert.blade.php added your inputs (Each input must have a name) after that you can go to PostRequest in case you want to validate creation and update finally go to Post model and add the name of your inputs in fillable

in case you have simple crud and want to create index and upsert in same page use 

```
php artisan phinx:crud Name --type=single
```

in case you want upsert page and index page

```
php artisan phinx:crud Name --type=multi
```


<h2>Form Ajax</h2>

Phinx Core contain powerfull ajax form that you will be able to send your data without write any js line 

<h3>Form Attributes</h3>

<table>
    <tr>
        <th>Name</th>
        <th>Job</th>
    </tr>
    <tr>
        <td>swalOnSuccess</td>
        <td>Throw success swal if the form accepted</td>
    </tr>
    <tr>
        <td>swalOnFail</td>
        <td>Throw error swal if the form rejected</td>
    </tr>
     <tr>
        <td>refreshAfterSend</td>
        <td>Refresh the current page if the form accepted</td>
    </tr>
     <tr>
        <td>callback</td>
        <td>call a function if the form accepted</td>
    </tr>
    <tr>
        <td>beforeSend</td>
        <td>call a function before send the form</td>
    </tr>
    <tr>
        <td>beforeSend</td>
        <td>call a function before send the form</td>
    </tr>
    <tr>
        <td>methodAppend</td>
        <td>reject the form data that come from form and send the form data that return from method of append </td>
    </tr>
    <tr>
        <td>appendToData</td>
        <td>add to form data that come from the form the form data that return from appendToData method</td>
    </tr>
</table>

Example on form

```
<form class="ajax-form" method="post" action="{{ route('info.store') }}" swalOnSuccess="Data saved successfully">
    <input name="test" placeholder="test placeholder" value="test">
</form>
```

Now by looking of the upper form after submit this form will send ajax request contain formData contain field called test  with value test to the route info.store with method post after send it swal success will work

<h2>Form Inputs</h2>

Summernote
```
<textarea class="summernote w-100" name="value"> </textarea>
```

Multi select box
```
 <select multiple="multiple" class="testselect2" name="test[]">
    <option selected value="eg1">eg1</option>
    <option value="saab">Saab</option>
    <option value="eg2">eg2</option>
    <option value="eg3">eg3</option>
</select> 
```


Select Box
```
 <select name="type" class="form-control form-select select2" data-bs-placeholder="Select Country" readonly>
    <option value="facebook">Facebook</option>
    <option value="twitter">Twitter</option>
    <option value="instgram">Instgram</option>
    <option value="whatsapp" selected>What's App</option>
    <option value="phone" selected>Phone</option>
    <option value="email" selected>Email</option>
    <option value="location" selected>Location</option>
</select>
```



Extra section

```
 <div class="d-flex">
    <label for="title">
        Includes
    </label>
    <i class="fa fa-plus mx-2 mt-1 remove_section extra_section" data-insert=".insert_gallary" data-container=".include_container" method-append="appendInclude"></i>
</div>
function appendInclude()
{
    let index = $('.include_container').children().length;

    return `<input class="include" name="include['value'][${index}]">`
}
```

By using extra section you append multi value for same name input[]  you have to add method return the html of sections and added it to method-append

<h2>Error Handling</h2>

Each crud create Form Request with it so after create your crud add all your validation in it and to catch the error you can simply use error handler 

Example 

```
<input type="text" name="test">
<p class="error error_test"></p>
```
so any validation error happend on key test error_test will catch it and show it


<h2>Image Service</h2>

In case that you want to deal with image image service will save alot of time for you as you can manipulate your images very easy  first you have to use it in your model after that use it as trait 

Example

```
use App\Http\Services\ImageService;

class User {
    use ImageService;
}

```

After that you can simple use it as following 

```
     $hotel = Hotel::find(1);
     $hotel->dimintions(['large' => '1602x1067','small' => '261x164'])
            ->resize()
            ->files($request->thumbnail)
            ->withSaveRelation('gallaries')
            ->usefor('thumbnail')
            ->compile();
  ```
  
  
  <table>
    
    <tr>
        <th>Key</th>
        <th>Value</th>
    </tr>
    
 
  </table>

