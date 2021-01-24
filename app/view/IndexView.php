<main>

    <div class="content">
        <ul id="js-grid">
            <?= $this->toHtml($this->getFiles($_SESSION['login']));?>
        </ul>
    </div>

    <div id="js-show-img">
        <span>
            <button id="js-show-close">X</button>
            <img src="/assets/imgs/img1.png"/>
        </span>
    </div>


    <div class="file" id="js-file" >
        <div class="file__center">
            <h3>Add a new photo</h3>
            <form enctype="multipart/form-data" action="/file/add" method="POST">
                <label>Label</label>
                <input  maxlength="100" type="text" name="label" placeholder="" required/>
                
                <label>Photo URL</label>
                <input type="text" name="photo-url" placeholder="" />

                <span>
                    <button type="button" id="js-add-cancel">Cancel</button>
                    <button>Submit</button>
                </span>

            </form>
        </div>
    </div>


</main>
