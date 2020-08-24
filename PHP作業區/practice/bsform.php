<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bootstrap form</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.css">
    <style>
        nav {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabIndex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="alert alert-info" role="alert">
                    <pre>
                    <?php
                    print_r($_POST);
                    ?>
                </pre>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <form method="post">
                    <div class="form-group">
                        <label for="Email1">Email address</label>
                        <input type="email" class="form-control" id="Email1" placeholder="Enter email" name="Email1">
                    </div>
                    <div class="form-group">
                        <label for="Password">Password</label>
                        <input type="password" class="form-control" id="Password" placeholder="Password" name="Password">
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>
                    <select class="form-control form-control-lg" name="place">
                        <option>台北</option>
                        <option>台中</option>
                        <option>南投</option>
                    </select>
                    <br>
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="class" id="inlineRadio1" value="front-end">
                            <label class="form-check-label" for="inlineRadio1">front-end</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="class" id="inlineRadio2" value="back-end">
                            <label class="form-check-label" for="inlineRadio2">back-end</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="class" id="inlineRadio3" value="ui/ux">
                            <label class="form-check-label" for="inlineRadio3">ui/ux</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="html" name="skill[]">
                            <label class="form-check-label" for="inlineCheckbox1">html</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="css" name="skill[]">
                            <label class="form-check-label" for="inlineCheckbox2">css</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="php" name="skill[]">
                            <label class="form-check-label" for="inlineCheckbox3">php</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script src="./jquery-3.5.1.min.js"></script>
    <script src="./bootstrap/js/bootstrap.js"></script>
    <script>
        function checkCheckBox() {
            document.querySelectorAll('[name=skill\\[\\]]').forEach((item) => {
                console.log(item.value, item.checked);
            })
        }
    </script>
</body>

</html>