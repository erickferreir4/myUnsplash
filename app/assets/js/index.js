'use strict';

const Index = {

    __view() {

        let imgs = doc.querySelectorAll('.js-view');

        let closure_ = (el) => {
            return (ev) => {

                if( ev.target.classList.contains('js-delete') ) {
                    return
                }

                let src = el.querySelector('img').src
                let show = doc.querySelector('#js-show-img')

                show.querySelector('#js-show-img img')
                    .src = src;

                show.classList.add('is--active')
            }
        }

        imgs.forEach(el => {
            el.classList.remove('js-view')
            el.querySelector('figure')
                .addEventListener('click', closure_(el), false)
        })
    },

    __closeView() {
        let btn = doc.querySelector('#js-show-img')

        let closure_ = (ev) => {
            if( ev.target.id === 'js-show-img' ) {
                doc.querySelector('#js-show-img')
                    .classList.remove('is--active')
            }
            else if( ev.target.id === 'js-show-close' ) {
                doc.querySelector('#js-show-img')
                    .classList.remove('is--active')
            }
        }

        btn.addEventListener('click', closure_, false)
    },

    __search() {

        let input = doc.querySelector('#js-search')
        
        let closure_ = (ev) => {
            let search = ev.target.value
            let grid = doc.querySelectorAll('#js-grid li')

            grid.forEach( el => {
                let img_name = el.querySelector('figcaption').innerText

                el.style.display = 'none';

                let re = new RegExp(search.toLowerCase())
                if( re.test(img_name.toLowerCase()) ) {
                    el.style.display = 'block' 
                }
            })
        }

        input.addEventListener('keyup', closure_, false)
    },

    __addPhoto() {
        let btn = doc.querySelector('#js-add')

        let closure_ = ev => {
            doc.querySelector('#js-file')
                .classList.add('is--active')
        }

        btn.addEventListener('click', closure_, false)
    },

    __addCancel() {

        let btn = doc.querySelector('#js-file')

        let closure_ = ev => {

            if( ev.target.id === 'js-file' ) {
                doc.querySelector('#js-file')
                    .classList.remove('is--active')
            }
            else if ( ev.target.id === 'js-add-cancel' ) {
                doc.querySelector('#js-file')
                    .classList.remove('is--active')
            }

        }

        btn.addEventListener('click', closure_, false)
    },

    __delete() {
        let btn = doc.querySelectorAll('.js-delete')

        let closure_ = ev => {

            let file = ev.target.nextElementSibling.src

            let data = new FormData();
            data.append('photo_url', file)

            fetch("/file/delete", {method: "POST",body: data})
            ev.target.closest('li').remove();


            if( !doc.querySelectorAll('#js-grid li').length ) {
                location.reload();
            } 
        }

        btn.forEach( el => {
            el.addEventListener('click', closure_, false)
        })
    },



    init() {
        this.__view();
        this.__closeView();
        this.__search();
        this.__addPhoto();
        this.__addCancel();
        this.__delete();
    }
}



if( doc.readyState !== 'loading' ) {
    Index.init();
} else {
    doc.addEventListener('DOMContentLoaded', () => {
        Index.init();
    })
}
