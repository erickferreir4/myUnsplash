<header>
    <div class="header-center">

        <div>
            <img src="/assets/imgs/user.svg"/>
            <span>
                <h3>My Unsplash</h3>
                <p id="user-id"><?=$_SESSION['login']?></p>
            </span>
        </div>

        <div>
            <input type="text" id="js-search" placeholder="Search by name"/>
            <i><img src="/assets/imgs/loupe.svg" /></i>
        </div>

        <div>
            <button id="js-add">Add a photo</button>
        </div>

    </div>
</header>
