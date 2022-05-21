<nav class="global-nav">
        <div class="globalContainer">
            <a class="logoContainer" href="<?php echo url_for('home'); ?>">
                <img class="site-logo" src="<?php echo url_for('frontend/assets/images/netflix.png') ?>" alt="Site Logo">
            </a>
        </div>
        <ul class="nav-links">
            <li><a href="<?php echo url_for('home'); ?>">HOME</a></li>
            <li><a href="<?php echo url_for('tvshows'); ?>">TV SHOWS</a></li>
            <li><a href="<?php echo url_for('movies'); ?>">MOVIES</a></li>
            <li><a href="<?php echo url_for('recentlyadded'); ?>">RECENTLY ADDED</a></li>
        </ul>
        <div class="right-nav">
            <giv class="global-search-container">
                <input type="text" placeholder="Search Movie" aria-label="Search Movie" class="search">
                <i class="fas fa-search"></i>
            </giv>
            <a href="<?php echo url_for('profile'); ?>"><i class="fas fa-user"></i></a>
            <a href="<?php echo url_for('logout'); ?>">Logout</a>
        </div>
    </nav>