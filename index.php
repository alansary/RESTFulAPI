<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="RESTFul API">
    <meta name="author" content="Mohamed Alansary">
    <link rel="icon" href="assets/restfulapi.png">

    <title>RESTFulAPI</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="assets/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/blog.css" rel="stylesheet">

    <script src="assets/ie-emulation-modes-warning.js"></script>

    <link rel="stylesheet" href="assets/prism.css">

  </head>

  <body>

    <div class="blog-masthead">
      <div class="container">
        <nav class="blog-nav">
          <a class="blog-nav-item active" href="#">Home</a>
          <a class="blog-nav-item" href="#DatabaseSchema">Database Docs</a>
          <a class="blog-nav-item" href="#GetAllUsers">User Docs</a>
          <a class="blog-nav-item" href="#GetAllWorks">Work Docs</a>
          <a class="blog-nav-item" href="#GetAllMilestones">Milestone Docs</a>
        </nav>
      </div>
    </div>

    <div class="container">

      <div class="blog-header">
        <h1 class="blog-title">RESTFul API</h1>
        <p class="lead blog-description">GET POST PUT DELETE REQUESTS RESTFul API</p>
      </div>

      <div class="row">

        <div class="col-sm-8 blog-main">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      How images are stored and sent through JSON
                    </a>
                  </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    Images are stored as Blob type, to pass the image to JSON, we have two options, either passing its link or encoding the image to base46 encoding while representation and decoding the image while storage, option two is choosen here for the sake of demonstration.
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                  <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      API key for database connection
                    </a>
                  </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                  <div class="panel-body">
                    The API KEY will be sent by email and it must be correct in order to connect with the database.
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                  <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      Image concern due to free hosting
                    </a>
                  </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                  <div class="panel-body">
                    Choose small images (smaller than 46 Kb) because of the free hosting since there is no charge by now to host on a droplet on digital ocean.
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingFour">
                  <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                      host variable
                    </a>
                  </h4>
                </div>
                <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                  <div class="panel-body">
                    Replace host with http://restfulapi-test.000webhostapp.com
                  </div>
                </div>
              </div>
            </div>

          <div class="blog-post" id="DatabaseSchema">
            <h2 class="blog-post-title">Database Schema</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
              <pre><code class="language-sql">
CREATE DATABASE api;

USE api;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(256) NOT NULL,
  `password` VARCHAR(256) NOT NULL,
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TRIGGER `users_INSERT` BEFORE INSERT ON `users`
FOR EACH ROW BEGIN
        -- Set the creation date
    SET new.created = now();

        -- Set the udpate date
    Set new.modified = now();
END;

CREATE TRIGGER `users_UPDATE` BEFORE UPDATE ON `users`
FOR EACH ROW BEGIN
        -- Set the udpate date
    Set new.modified = now();
END;

CREATE TABLE IF NOT EXISTS `works` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `description` TEXT DEFAULT '',
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES users (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TRIGGER `works_INSERT` BEFORE INSERT ON `works`
FOR EACH ROW BEGIN
        -- Set the creation date
    SET new.created = now();

        -- Set the udpate date
    Set new.modified = now();
END;

CREATE TRIGGER `works_UPDATE` BEFORE UPDATE ON `works`
FOR EACH ROW BEGIN
        -- Set the udpate date
    Set new.modified = now();
END;

CREATE TABLE IF NOT EXISTS `milestones` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `work_id` INT(11) NOT NULL,
  `deliverables` TEXT NOT NULL,
  `payment` DECIMAL(10, 2) NOT NULL,
  `deadline` TIMESTAMP NOT NULL,
  `image` BLOB NOT NULL,
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`work_id`) REFERENCES works (`id`),
  CHECK (`deadline` > CURRENT_TIMESTAMP)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TRIGGER `milestones_INSERT` BEFORE INSERT ON `milestones`
FOR EACH ROW BEGIN
        -- Set the creation date
    SET new.created = now();

        -- Set the udpate date
    Set new.modified = now();
END;

CREATE TRIGGER `milestones_UPDATE` BEFORE UPDATE ON `milestones`
FOR EACH ROW BEGIN
        -- Set the udpate date
    Set new.modified = now();
END;

CREATE TABLE IF NOT EXISTS `api_keys` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `api_key` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`api_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="GetAllUsers">
            <h2 class="blog-post-title">Get All Users</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host and key with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
      <script>
        window.onload = function() {
          var request = new XMLHttpRequest();
          var host = "HOST";
          var key = "YOUR API KEY";
          responseURL = host + "/api/user/api.php?key=" + key;
          request.open('GET', responseURL, true);
          request.responseType = 'text';
          request.setRequestHeader("Content-Type", "application/json");
          request.send();
          request.onreadystatechange = function() {
            var done = 4;
            var ok = 200;
            console.log(request);
            if (request.readyState == done && request.status == ok) {
              var response = request.responseText;
              console.log(JSON.parse(response));
              document.getElementById('response').innerHTML = response;
            }
          }
        }
      </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="GetUserById">
            <h2 class="blog-post-title">Get User By Id</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key and id with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var id = ID;
        var host = "HOST";
        responseURL = host + "/api/user/api.php?key=" + key + "&id=" + id;
        request.open('GET', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/json");
        request.send();
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(JSON.parse(response));
            document.getElementById('response').innerHTML = response;
          }
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="GetUserByUsername">
            <h2 class="blog-post-title">Get User By Username</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key and username with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var username = "USERNAME";
        var host = "HOST";
        responseURL = host + "/api/user/api.php?key=" + key + "&username=" + username;
        request.open('GET', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/json");
        request.send();
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(JSON.parse(response));
            document.getElementById('response').innerHTML = response;
          }
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="PostNewUser">
            <h2 class="blog-post-title">Post New User</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key, id, username, password, created and modified with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var id = ID;
        var username = "USERNAME";
        var password = "PASSWORD";
        var created = "YYYY-MM-DDTHH:MM:SS";
        var modified = "YYYY-MM-DDTHH:MM:SS";
        var host = "HOST";
        responseURL = host + "/api/user/api.php";
        request.open('POST', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("key=" + key + "&id=" + id + "&username=" + username + "&password=" + password + "&created=" + created + "&modified=" + modified);
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(response);
            document.getElementById('response').innerHTML = response;
          }
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="UpdateUserId">
            <h2 class="blog-post-title">Update User Id</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key, id and new_id with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var method = "PUT";
        var id = ID;
        var new_id = NEW_ID;
        var host = "HOST";
        responseURL = host + "/api/user/api.php";
        request.open('POST', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("key=" + key + "&method=" + method + "&id=" + id + "&new_id=" + new_id);
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(response);
            document.getElementById('response').innerHTML = response;
          }
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="UpdateUserUsername">
            <h2 class="blog-post-title">Update User Username</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key, id and username with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var method = "PUT";
        var id = ID;
        var username = 'USERNAME';
        var host = "HOST";
        responseURL = host + "/api/user/api.php";
        request.open('POST', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("key=" + key + "&method=" + method + "&id=" + id + "&username=" + username);
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(response);
            document.getElementById('response').innerHTML = response;
          }
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="UpdateUserPassword">
            <h2 class="blog-post-title">Update User Password</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key, id and password with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var method = "PUT";
        var id = ID;
        var password = "PASSWORD";
        var host = "HOST";
        responseURL = host + "/api/user/api.php";
        request.open('POST', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("key=" + key + "&method=" + method + "&id=" + id + "&password=" + password);
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(response);
            document.getElementById('response').innerHTML = response;
          }
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="UpdateUserCreatedDate">
            <h2 class="blog-post-title">Update User Created Date</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key, id and created with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var method = "PUT";
        var id = ID;
        var created = "YYYY-MM-DDTHH:MM:SS";
        var host = "HOST";
        responseURL = host + "/api/user/api.php";
        request.open('POST', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("key=" + key + "&method=" + method + "&id=" + id + "&created=" + created);
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(response);
            document.getElementById('response').innerHTML = response;
          }
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="UpdateUserModifiedDate">
            <h2 class="blog-post-title">Update User Modified Date</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key, id and modified with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var method = "PUT";
        var id = ID;
        var modified = "YYYY-MM-DDTHH:MM:SS";
        var host = "HOST";
        responseURL = host + "/api/user/api.php";
        request.open('POST', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("key=" + key + "&method=" + method + "&id=" + id + "&modified=" + modified);
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(response);
            document.getElementById('response').innerHTML = response;
          }
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="DeleteUserById">
            <h2 class="blog-post-title">Delete User By Id</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key and id with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var id = ID;
        var method = 'DELETE';
        var host = "HOST";
        responseURL = host + "/api/user/api.php";
        request.open('POST', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("key=" + key + "&id=" + id + "&method=" + method);
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(response);
            document.getElementById('response').innerHTML = response;
          }
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="DeleteUserByUsername">
            <h2 class="blog-post-title">Delete User By Username</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key and username with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var username = "USERNAME";
        var method = 'DELETE';
        var host = "HOST";
        responseURL = host + "/api/user/api.php";
        request.open('POST', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("key=" + key + "&username=" + username + "&method=" + method);
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(response);
            document.getElementById('response').innerHTML = response;
          }
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="GetAllWorks">
            <h2 class="blog-post-title">Get All Works</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host and key with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var host = "HOST";
        responseURL = host + "/api/work/api.php?key=" + key;
        request.open('GET', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/json");
        request.send();
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(JSON.parse(response));
            document.getElementById('response').innerHTML = response;
          }
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="GetWorkById">
            <h2 class="blog-post-title">Get Work By Id</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key and id with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var id = ID;
        var host = "HOST";
        responseURL = host + "/api/work/api.php?key=" + key + "&id=" + id;
        request.open('GET', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/json");
        request.send();
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(JSON.parse(response));
            document.getElementById('response').innerHTML = response;
          }
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="GetWorksByUserId">
            <h2 class="blog-post-title">Get Works By User Id</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key and id with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var user_id = USER_ID;
        var host = "HOST";
        responseURL = host + "/api/work/api.php?key=" + key + "&user_id=" + user_id;
        request.open('GET', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/json");
        request.send();
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(JSON.parse(response));
            document.getElementById('response').innerHTML = response;
          }
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="PostNewWork">
            <h2 class="blog-post-title">Post New Work</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key, id, user_id, description, created and modified with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var id = ID;
        var user_id = USER_ID;
        var description = "DESCRIPTION";
        var created = "YYYY-MM-DDTHH:MM:SS";
        var modified = "YYYY-MM-DDTHH:MM:SS";
        var host = "HOST";
        responseURL = host + "/api/work/api.php";
        request.open('POST', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("key=" + key + "&id=" + id + "&user_id=" + user_id + "&description=" + description + "&created=" + created + "&modified=" + modified);
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(response);
            document.getElementById('response').innerHTML = response;
          }
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="UpdateWorkId">
            <h2 class="blog-post-title">Update Work Id</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key, id and new_id with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var id = ID;
        var new_id = NEW_ID;
        var method = "PUT";
        var host = "HOST";
        responseURL = host + "/api/work/api.php";
        request.open('POST', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("key=" + key + "&id=" + id + "&new_id=" + new_id + "&method=" + method);
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(response);
            document.getElementById('response').innerHTML = response;
          }
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="UpdateWorkUserId">
            <h2 class="blog-post-title">Update Work User Id</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key, id and user_id with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var id = ID;
        var user_id = USER_ID;
        var method = "PUT";
        var host = "HOST";
        responseURL = host + "/api/work/api.php";
        request.open('POST', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("key=" + key + "&id=" + id + "&user_id=" + user_id + "&method=" + method);
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(response);
            document.getElementById('response').innerHTML = response;
          }
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="UpdateWorkDescription">
            <h2 class="blog-post-title">Update Work Description</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key, id and description with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var id = ID;
        var description = "DESCRIPTION";
        var method = "PUT";
        var host = "HOST";
        responseURL = host + "/api/work/api.php";
        request.open('POST', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("key=" + key + "&id=" + id + "&description=" + description + "&method=" + method);
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(response);
            document.getElementById('response').innerHTML = response;
          }
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="UpdateWorkCreatedDate">
            <h2 class="blog-post-title">Update Work Created Date</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key, id and created with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var id = ID;
        var created = "YYYY-MM-DDTHH:MM:SS";
        var method = "PUT";
        var host = "HOST";
        responseURL = host + "/api/work/api.php";
        request.open('POST', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("key=" + key + "&id=" + id + "&created=" + created + "&method=" + method);
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(response);
            document.getElementById('response').innerHTML = response;
          }
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="UpdateWorkModifiedDate">
            <h2 class="blog-post-title">Update Work Modified Date</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key, id and modified with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var id = ID;
        var modified = "YYYY-MM-DDTHH:MM:SS";
        var method = "PUT";
        var host = "HOST";
        responseURL = host + "/api/work/api.php";
        request.open('POST', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("key=" + key + "&id=" + id + "&modified=" + modified + "&method=" + method);
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(response);
            document.getElementById('response').innerHTML = response;
          }
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="DeleteWorkById">
            <h2 class="blog-post-title">Delete Work By Id</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key and id with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var id = ID;
        var method = "DELETE";
        var host = "HOST";
        responseURL = host + "/api/work/api.php";
        request.open('POST', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("key=" + key + "&id=" + id + "&method=" + method);
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(response);
            document.getElementById('response').innerHTML = response;
          }
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="DeleteWorkByUserId">
            <h2 class="blog-post-title">Delete Work By User Id</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key and user_id with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var user_id = ID;
        var method = "DELETE";
        var host = "HOST";
        responseURL = host + "/api/work/api.php";
        request.open('POST', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("key=" + key + "&user_id=" + user_id + "&method=" + method);
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(response);
            document.getElementById('response').innerHTML = response;
          }
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="GetAllMilestones">
            <h2 class="blog-post-title">Get All Milestones</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host and key with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var host = "HOST";
        responseURL = host + "/api/milestone/api.php?key=" + key;
        request.open('GET', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/json");
        request.send();
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(JSON.parse(response));
            document.getElementById('response').innerHTML = response;
          }
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="GetMilestoneById">
            <h2 class="blog-post-title">Get Milestone By Id</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key and id with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var id = ID;
        var host = "HOST";
        responseURL = host + "/api/milestone/api.php?key=" + key + "&id=" + id;
        request.open('GET', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/json");
        request.send();
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(JSON.parse(response));
            document.getElementById('response').innerHTML = response;
          }
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="GetMilestonesByUserId">
            <h2 class="blog-post-title">Get Milestones By User Id</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key and user_id with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var user_id = USER_ID;
        var host = "HOST";
        responseURL = host + "/api/milestone/api.php?key=" + key + "&user_id=" + user_id;
        request.open('GET', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/json");
        request.send();
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(JSON.parse(response));
            document.getElementById('response').innerHTML = response;
          }
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="GetMilestonesByWorkId">
            <h2 class="blog-post-title">Get Milestones By Work Id</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key and work_id with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var work_id = WORK_ID;
        var host = "HOST";
        responseURL = host + "/api/milestone/api.php?key=" + key + "&work_id=" + work_id;
        request.open('GET', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/json");
        request.send();
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(JSON.parse(response));
            document.getElementById('response').innerHTML = response;
          }
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="PostNewMilestone">
            <h2 class="blog-post-title">Post New Milestone</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key, id, work_id, deliverables, payment, deadline, IMAGEABSOLUTEPATH, created and modified with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        function toDataURL(src, callback, outputFormat) {
          var img = new Image();
          img.crossOrigin = 'Anonymous';
          img.onload = function() {
            console.log('img onload');
            var canvas = document.createElement('CANVAS');
            var ctx = canvas.getContext('2d');
            var dataURL;
            canvas.height = this.naturalHeight;
            canvas.width = this.naturalWidth;
            ctx.drawImage(this, 0, 0);
            dataURL = canvas.toDataURL(outputFormat);
            callback(dataURL);
          };
          img.src = src;
        }

        toDataURL(
          'IMAGEABSOLUTEPATH',
          function(dataUrl) {
            var request = new XMLHttpRequest();
            var key = "KEY";
            var id = ID;
            var work_id = WORK_ID;
            var deliverables = "DELIVERABLES";
            var payment = PAYMENT;
            var deadline = "YYYY-MM-DDTHH:MM:SS";
            var image = dataUrl;
            var created = "YYYY-MM-DDTHH:MM:SS";
            var modified = "YYYY-MM-DDTHH:MM:SS";
            var host = "HOST";
            responseURL = host + "/api/milestone/api.php";
            request.open('POST', responseURL, true);
            request.responseType = 'text';
            request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            request.send("key=" + key + "&id=" + id + "&work_id=" + work_id + "&deliverables=" + deliverables + "&payment=" + payment + "&deadline=" + deadline + "&image=" + image + "&created=" + created + "&modified=" + modified);
            request.onreadystatechange = function() {
              var done = 4;
              var ok = 200;
              console.log(request);
              if (request.readyState == done && request.status == ok) {
                var response = request.responseText;
                console.log(response);
                document.getElementById('response').innerHTML = response;
              } // end if
            } // end onreadystatechange
          },
          'image/jpg'
        );
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="UpdateMilestoneId">
            <h2 class="blog-post-title">Update Milestone Id</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key, id and new_id with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var method = "PUT";
        var id = ID;
        var new_id = NEW_ID;
        var host = "HOST";
        responseURL = host + "/api/milestone/api.php";
        request.open('POST', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("key=" + key + "&id=" + id + "&method=" + method + "&new_id=" + new_id);
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(response);
            document.getElementById('response').innerHTML = response;
          } // end if
        } // end onreadystatechange
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="UpdateMilestoneDeliverables">
            <h2 class="blog-post-title">Update Milestone Deliverables</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key, id and deliverables with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var method = "PUT";
        var id = ID;
        var deliverables = "DELIVERABLES";
        var host = "HOST";
        responseURL = host + "/api/milestone/api.php";
        request.open('POST', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("key=" + key + "&id=" + id + "&method=" + method + "&deliverables=" + deliverables);
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(response);
            document.getElementById('response').innerHTML = response;
          } // end if
        } // end onreadystatechange
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="UpdateMilestonePayment">
            <h2 class="blog-post-title">Update Milestone Payment</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key, id and payment with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var method = "PUT";
        var id = ID;
        var payment = PAYMENT;
        var host = "HOST";
        responseURL = host + "/api/milestone/api.php";
        request.open('POST', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("key=" + key + "&id=" + id + "&method=" + method + "&payment=" + payment);
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(response);
            document.getElementById('response').innerHTML = response;
          } // end if
        } // end onreadystatechange
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="UpdateMilestoneWorkId">
            <h2 class="blog-post-title">Update Milestone Work Id</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key, id and work_id with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var method = "PUT";
        var id = ID;
        var work_id = WORK_ID;
        var host = "HOST";
        responseURL = host + "/api/milestone/api.php";
        request.open('POST', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("key=" + key + "&id=" + id + "&method=" + method + "&work_id=" + work_id);
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(response);
            document.getElementById('response').innerHTML = response;
          } // end if
        } // end onreadystatechange
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="UpdateMilestoneImage">
            <h2 class="blog-post-title">Update Milestone Image</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key, id and IMAGEABSOLUTEPATH with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        function toDataURL(src, callback, outputFormat) {
          var img = new Image();
          img.crossOrigin = 'Anonymous';
          img.onload = function() {
            console.log('img onload');
            var canvas = document.createElement('CANVAS');
            var ctx = canvas.getContext('2d');
            var dataURL;
            canvas.height = this.naturalHeight;
            canvas.width = this.naturalWidth;
            ctx.drawImage(this, 0, 0);
            dataURL = canvas.toDataURL(outputFormat);
            callback(dataURL);
          };
          img.src = src;
        }

        toDataURL(
          'IMAGEABSOLUTEPATH',
          function(dataUrl) {
            var request = new XMLHttpRequest();
            var key = "YOUR API KEY";
            var method = "PUT";
            var id = ID;
            var image = dataUrl;
            var host = "HOST";
            responseURL = host + "/api/milestone/api.php";
            request.open('POST', responseURL, true);
            request.responseType = 'text';
            request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            request.send("key=" + key + "&id=" + id + "&method=" + method + "&image=" + image);
            request.onreadystatechange = function() {
              var done = 4;
              var ok = 200;
              console.log(request);
              if (request.readyState == done && request.status == ok) {
                var response = request.responseText;
                console.log(response);
                document.getElementById('response').innerHTML = response;
              } // end if
            } // end onreadystatechange
          },
          'image/jpg'
        );
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="UpdateMilestoneCreatedDate">
            <h2 class="blog-post-title">Update Milestone Created Date</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key, id and created with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var method = "PUT";
        var id = ID;
        var created = "YYYY-MM-DDTHH:MM:SS";
        var host = "HOST";
        responseURL = host + "/api/milestone/api.php";
        request.open('POST', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("key=" + key + "&id=" + id + "&method=" + method + "&created=" + created);
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(response);
            document.getElementById('response').innerHTML = response;
          } // end if
        } // end onreadystatechange
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="UpdateMilestoneModifiedDate">
            <h2 class="blog-post-title">Update Milestone Modified Date</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key, id and modified with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var method = "PUT";
        var id = ID;
        var modified = "YYYY-MM-DDTHH:MM:SS";
        var host = "HOST";
        responseURL = host + "/api/milestone/api.php";
        request.open('POST', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("key=" + key + "&id=" + id + "&method=" + method + "&modified=" + modified);
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(response);
            document.getElementById('response').innerHTML = response;
          } // end if
        } // end onreadystatechange
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="UpdateMilestoneDeadlineDate">
            <h2 class="blog-post-title">Update Milestone Deadline Date</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key, id and deadline with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var method = "PUT";
        var id = ID;
        var deadline = "YYYY-MM-DDTHH:MM:SS";
        var host = "HOST";
        responseURL = host + "/api/milestone/api.php";
        request.open('POST', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("key=" + key + "&id=" + id + "&method=" + method + "&deadline=" + deadline);
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(response);
            document.getElementById('response').innerHTML = response;
          } // end if
        } // end onreadystatechange
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="DeleteMilestoneById">
            <h2 class="blog-post-title">Delete Milestone By Id</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key and id with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var id = ID;
        var method = 'DELETE';
        var host = "HOST";
        responseURL = host + "/api/milestone/api.php";
        request.open('POST', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("key=" + key + "&id=" + id + "&method=" + method);
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(response);
            document.getElementById('response').innerHTML = response;
          } // end if
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="DeleteMilestonesByWorkId">
            <h2 class="blog-post-title">Delete Milestones By Work Id</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key and work_id with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var work_id = WORK_ID;
        var method = 'DELETE';
        var host = "HOST";
        responseURL = host + "/api/milestone/api.php";
        request.open('POST', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("key=" + key + "&work_id=" + work_id + "&method=" + method);
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(response);
            document.getElementById('response').innerHTML = response;
          } // end if
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

          <div class="blog-post" id="DeleteMilestonesByUserId">
            <h2 class="blog-post-title">Delete Milestones By User Id</h2>
            <p class="blog-post-meta">Tnu 31 Aug, 2017 by <a href="https://github.com/alansary">Mohamed Alansary</a></p>
            <div class="alert alert-success">
              Replace host, key and user_id with the proper values
            </div>
              <pre><code class="language-html">
&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;TestAPI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div id=&quot;response&quot;&gt;&lt;/div&gt;
    &lt;script&gt;
              </code></pre>
              <pre><code class="language-javascript">
    <script>
      window.onload = function() {
        var request = new XMLHttpRequest();
        var key = "YOUR API KEY";
        var user_id = USER_ID;
        var method = 'DELETE';
        var host = "HOST";
        responseURL = host + "/api/milestone/api.php";
        request.open('POST', responseURL, true);
        request.responseType = 'text';
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("key=" + key + "&work_id=" + user_id + "&method=" + method);
        request.onreadystatechange = function() {
          var done = 4;
          var ok = 200;
          console.log(request);
          if (request.readyState == done && request.status == ok) {
            var response = request.responseText;
            console.log(response);
            document.getElementById('response').innerHTML = response;
          } // end if
        }
      }
    </script>
              </code></pre>
              <pre><code class="language-html">
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
              </code></pre>
          </div><!-- /.blog-post -->

        </div><!-- /.blog-main -->

        <div class="col-sm-3 col-sm-offset-1 blog-sidebar">
          <div class="sidebar-module">
            <h4>Documentation</h4>
            <ol class="list-unstyled">
              <li><a href="#DatabaseSchema">Database Schema</a></li>
              <li><a href="#GetAllUsers">Get All Users</a></li>
              <li><a href="#GetUserById">Get User By Id</a></li>
              <li><a href="#GetUserByUsername">Get User By Username</a></li>
              <li><a href="#PostNewUser">Post New User</a></li>
              <li><a href="#UpdateUserId">Update User Id</a></li>
              <li><a href="#UpdateUserUsername">Update User Username</a></li>
              <li><a href="#UpdateUserPassword">Update User Password</a></li>
              <li><a href="#UpdateUserCreatedDate">Update User Created Date</a></li>
              <li><a href="#UpdateUserModifiedDate">Update User Modified Date</a></li>
              <li><a href="#DeleteUserById">Delete User By Id</a></li>
              <li><a href="#DeleteUserByUsername">Delete User By Username</a></li>
              <li><a href="#GetAllWorks">Get All Works</a></li>
              <li><a href="#GetWorkById">Get Work By Id</a></li>
              <li><a href="#GetWorksByUserId">Get Works By User Id</a></li>
              <li><a href="#PostNewWork">Post New Work</a></li>
              <li><a href="#UpdateWorId">Update Work Id</a></li>
              <li><a href="#UpdateWorkUserId">Update Work User Id</a></li>
              <li><a href="#UpdateWorkDescription">Update Work Description</a></li>
              <li><a href="#UpdateWorkCreatedDate">Update Work Created Date</a></li>
              <li><a href="#UpdateWorkModifiedDate">Update Work Modified Date</a></li>
              <li><a href="#DeleteWorkById">Delete Work By Id</a></li>
              <li><a href="#DeleteWorkByUserId">Delete Works By User Id</a></li>
              <li><a href="#GetAllMilestones">Get All Milestones</a></li>
              <li><a href="#GetMilestoneById">Get Milestone By Id</a></li>
              <li><a href="#GetMilestonesByUserId">Get Milestones By User Id</a></li>
              <li><a href="#GetMilestonesByWorkId">Get Milestones By Work Id</a></li>
              <li><a href="#PostNewMilestone">Post New Milestone</a></li>
              <li><a href="#UpdateMilestoneId">Update Milestone Id</a></li>
              <li><a href="#UpdateMilestoneDeliverables">Update Milestone Deliverables</a></li>
              <li><a href="#UpdateMilestonePayment">Update Milestone Payment</a></li>
              <li><a href="#UpdateMilestoneWorkId">Update Milestone Work Id</a></li>
              <li><a href="#UpdateMilestoneImage">Update Milestone Image</a></li>
              <li><a href="#UpdateMilestoneCreatedDate">Update Milestone Created Date</a></li>
              <li><a href="#UpdateMilestoneModifiedDate">Update Milestone Modified Date</a></li>
              <li><a href="#UpdateMilestoneDeadlineDate">Update Milestone Deadline Date</a></li>
              <li><a href="#DeleteMilestoneById">Delete Milestone By Id</a></li>
              <li><a href="#DeleteMilestonesByWorkId">Delete Milestones By Work Id</a></li>
              <li><a href="#DeleteMilestonesByUserId">Delete Milestones By User Id</a></li>
            </ol>
          </div>
          <div class="sidebar-module">
            <h4>Elsewhere</h4>
            <ol class="list-unstyled">
              <li><a href="https://github.com/alansary">GitHub</a></li>
              <li><a href="https://www.linkedin.com/in/csmohamedalansary/">LinkedIn</a></li>
              <li><a href="https://wuzzuf.net/me/alansary">Wuzzuf</a></li>
            </ol>
          </div>
        </div><!-- /.blog-sidebar -->

      </div><!-- /.row -->

    </div><!-- /.container -->

    <footer class="blog-footer">
      <p>RESTFulAPI by <a href="https://github.com/alansary">@alansary</a>.</p>
      <p>
        <a href="#">Back to top</a>
      </p>
    </footer>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/jquery.min.js"><\/script>')</script>
    <script src="assets/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/ie10-viewport-bug-workaround.js"></script>
    <script src="assets/prism.js"></script>
  </body>
</html>
