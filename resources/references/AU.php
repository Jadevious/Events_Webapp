<!DOCTYPE html>
<HTML lang = 'en'>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content = 'width=device-width, initial-scale=1, shrink-to-fit=no'>
        <meta name='description' content = 'Aston Unofficial Official Website'>
        <meta name='author' content = 'Harry Lees'>
        <link rel='icon' href = '/static/images/logo.jpg'>
    
        <title>Aston Unofficial</title>
    
        <!-- Bootstrap core CSS -->
        <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/darkly/bootstrap.min.css' integrity='sha384-nNK9n28pDUDDgIiIqZ/MiyO3F4/9vsMtReZK39klb/MtkZI3/LtjSjlmyVPS3KdN' crossorigin='anonymous'> 

        <!-- Font Awesome CDN -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    </head>

    <style>
        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: nowrap;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .nav-scroller .nav-link {
            padding-top: .75rem;
            padding-bottom: .75rem;
            font-size: .875rem;
        }

        .underline {
            line-height: 1;
            border-bottom: 1px solid #e5e5e5;
        }
    </style>

    
    <style>
        .jumbotron {
            background-image: url("/static/images/aston.jpg");
            background-size: cover;
          }

        .text-shadow {
            text-shadow: 0 2px 0 black;
        }
    </style>


    <body>
        <div class = 'container'>

            <header class='underline py-3'>
                <div class="row flex-nowrap justify-content-between align-items-center">
                    <div class="col-4 text-center">
                    </div>
                    <div class="col-4 d-flex justify-content-end align-items-center">
                        <a class = 'btn btn-primary' href = '/login'>Sign in with Discord</a>
                    </div>
                </div>
            </header>

            <div class="nav-scroller py-1 mb-4">
                <nav class="nav d-flex justify-content-between">
                    <a class="p-2 text-muted" href = '/'>Home</a>
                    <a class="p-2 text-muted" href = '/status'>Status</a>
                    <a class="p-2 text-muted" href = '/commands'>Commands</a>
                    <a class="p-2 text-muted" href = '/help'>Help</a>
                    <a class="p-2 text-muted" href = 'https://github.com/Harry-Lees/Aston-Unofficial-Bot'>Github</a>
                </nav>
            </div>

            <main>
                
    <div class = 'jumbotron text-shadow'>
        <h1>Aston Unofficial Bot</h1>

        <p class = 'lead'>
            Whether you're a club, society, or just a group of friends. <br>
            If you're affiliated with Aston Univeristy, we can help! 
        </p>
    </div>

    <div class = 'text-center mt-5'>
        <h2>Features</h2>
    </div>

    <div class = 'album card-deck'>
        <div class='card'>
            <div class='card-body text-center'>
                <h1 class="fas fa-user-check text-success"></h1>
                <hr>
                <h3>Verification</h3>
                <p class = 'text-muted'>
                    An automatic verification system baked right into the bot ensures that all your members are verified members of Aston University.
                </p>
            </div>
        </div>

        <div class='card'>
            <div class='card-body text-center'>
                <h1 class="fas fa-user-shield text-success"></h1>
                <hr>
                <h3>Moderation</h3>
                <p class = 'text-muted'>
                    Keep a hold on your server with our powerful suite of moderation tools.
                </p>
            </div>
        </div>

        <div class='card'>
            <div class='card-body text-center'>
                <h1 class="fas fa-clipboard-list text-success"></h1>
                <hr>
                <h3>Dashboard</h3>
                <p class = 'text-muted'>
                    Our online dashboard allows you to keep track of everything that's going on in your server!
                </p>
            </div>
        </div>

    </div>

    <div class = 'container text-center mt-5'>
        <h2>Getting Started</h2>
        <p class = 'text-muted'>
            Currently we're individually consulting servers that use our bot. Please read our Help section for more information on adding this bot to your server.
        </p>
    </div>

            </main>

            <!-- Bootstrap Javascript -->
            <script src = "https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
            
            <script>
                window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')
            </script>
            
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
            
            <script>
                Holder.addTheme('thumb', {
                    bg: '#55595c',
                    fg: '#eceeef',
                    text: 'Thumbnail'
                });
            </script>

        </div>
    </body>
</HTML>