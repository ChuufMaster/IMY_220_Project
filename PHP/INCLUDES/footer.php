<div class="position-fixed bottom-0 start-50 translate-middle-x w-auto nav-custom mb-3 ">
    <div class="centered-bottom-div rounded" id="navbar-styler">
        <nav class="navbar navbar-expand-lg">
            <div class="nav-main-border p-1 rounded">
                <a class="navbar-brand rounded p-3" href="#">
                    Article Hub
                </a>
            </div>
            <div class="navbar-group-custom rounded me-1">
                <ul class="navbar-nav p-1 w-auto ">
                    <li class="nav-item mx-1 px-1 w-auto">
                        <div class="nav-item-border p-1 rounded">
                            <a class="nav-link mx-2 px-5 rounded" <?php echo 'href="home.php?api_key=' . $_GET['api_key'] . '"' ?>>
                                <i class="fa fa-house"></i>
                                HOME
                            </a>
                        </div>
                    </li>
                    <li class="nav-item px-1">
                        <div class="nav-item-border p-1">
                            <a class="nav-link mx-2 px-5 rounded" <?php echo 'href="activity.php?api_key=' . $_GET['api_key'] . '"' ?>>
                                <i class="fa-solid fa-hashtag"></i>
                                ACTIVITY
                            </a>
                        </div>
                    </li>
                    <li class="nav-item px-1">
                        <div class="nav-item-border p-1">
                            <a class="nav-link mx-2 px-5 rounded" <?php echo 'href="friends.php?api_key=' . $_GET['api_key'] . '"' ?>>
                                <i class="fa-solid fa-hashtag"></i>
                                FRIENDS
                            </a>
                        </div>
                    </li>
                    <li class="nav-item px-1">
                        <div class="nav-item-border p-1">
                            <a class="nav-link mx-2 px-5 rounded" <?php echo 'href="profile.php?api_key=' . $_GET['api_key'] . '"' ?>>
                                <i class="fa-solid fa-hashtag"></i>
                                PROFILE
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>