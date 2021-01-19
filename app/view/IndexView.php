<main>

    <div class="content">
        <ul id="js-grid">
            <li class="js-view">
                <figure>
                  <button class="js-delete">delete</button>
                  <img src="/assets/imgs/img3.png"/>
                  <figcaption>Fig.1 - Trulli, Puglia, Italy.</figcaption>
                </figure>
            </li>
            <li class="js-view">
                <figure>
                  <img src="/assets/imgs/img1.png"/>
                  <figcaption>Fig.1 - Trulli, Puglia, Italy.</figcaption>
                </figure>
            </li>
            <li class="js-view">
                <figure>
                  <img src="/assets/imgs/img2.png"/>
                  <figcaption>Fig.1 - Trulli, Brasil, Italy.</figcaption>
                </figure>
            </li>
            <li class="js-view">
                <figure>
                  <img src="/assets/imgs/img1.png"/>
                  <figcaption>Fig.1 - Trulli, Puglia, Italy.</figcaption>
                </figure>
            </li>
            <li class="js-view">
                <figure>
                  <img src="/assets/imgs/img2.png"/>
                  <figcaption>Fig.1 - Trulli, Puglia, Italy.</figcaption>
                </figure>
            </li>
            <li class="js-view">
                <figure>
                  <img src="/assets/imgs/img1.png"/>
                  <figcaption>Fig.1 - Trulli, Puglia, Italy.</figcaption>
                </figure>
            </li>
            <li class="js-view">
                <figure>
                  <img src="/assets/imgs/img1.png"/>
                  <figcaption>Fig.1 - Trulli, Puglia, Italy.</figcaption>
                </figure>
            </li>

        </ul>
    </div>

    <div id="js-show-img">
        <span>
            <button id="js-show-close">X</button>
            <img src="/assets/imgs/img1.png"/>
        </span>
    </div>


    <div class="file" id="js-file">
        <div class="file__center">
            <h3>Add a new photo</h3>
            <form>
                <label>Label</label>
                <input type="text" placeholder="" required/>
                
                <label>Photo URL</label>
                <input type="text" placeholder="" />

                <label>File</label>
                <button type="button" onclick="document.querySelector('#get-file').click()">Choose File</button>
                <input style="display: none;" type="file" id="get-file"/>
                <ul id="js-file-name"></ul>

                <span>
                    <button type="button" id="js-add-cancel">Cancel</button>
                    <button>Submit</button>
                </span>

            </form>
        </div>
    </div>


</main>
