function showFormAddCard(btn) {
    btn.style.display = 'none';
    btn.nextElementSibling.style.display = 'block';
    btn.nextElementSibling.querySelector('textarea').select();
}

function hideFormAddCard(form) {
    form.style.display = 'none';
    form.previousElementSibling.style.display = 'block';
}

document.addEventListener('DOMContentLoaded', () => {

    let board = document.querySelector('#todo-board'),
        btnOpenFormAddColumn = document.querySelector('#open_form_add_column'),
        btnCloseFormAddColumn = document.querySelector('#close_form_add_column'),
        formAddColumn = document.querySelector('#form_add_column'),
        btnAddColunm = document.querySelector('#btn_add_colunm');

    btnOpenFormAddColumn.addEventListener('click', () => {
        btnOpenFormAddColumn.style.display='none';

        formAddColumn.style.display='block';
        formAddColumn.querySelector('input[name="name"]').select();
    });

    btnCloseFormAddColumn.addEventListener('click', () => {
        formAddColumn.style.display='none';
        btnOpenFormAddColumn.style.display='block';
    });

    btnAddColunm.addEventListener('click', () => {
        formAddColumn.style.display='none';
        btnOpenFormAddColumn.style.display='block';

        $.request('onCreateColumn', {
            loading: $.wn.stripeLoadIndicator,
            data: {
                name: formAddColumn.querySelector('input[name="name"]').value,
                order: document.querySelectorAll('.board-column').length + 1
            },
            success: function(data) {
                let columns = document.querySelectorAll('.board-column');

                if (columns.length > 0) {
                    columns[columns.length - 1].insertAdjacentHTML('afterend', data.result);
                }
                else {
                    board.insertAdjacentHTML('afterbegin', data.result);
                }

                formAddColumn.querySelector('input[name="name"]').value = '';
            },
            error: function(jqXHR, status) {                

            }
        })
    });


    board.addEventListener('click', e => {
        /**
         * Кнопка открывающая форму добавления новой карточки
         */
        if ( e.target.classList.contains('btn-open-form-add-card') ) {
            showFormAddCard(e.target);
        }

        /**
         * Кнопка закрывающая форму добавления новой карточки
         */
        else if ( e.target.classList.contains('btn-close-form-add-card') ) {
            hideFormAddCard(e.target.parentElement.parentElement);
        }

        /**
         * Добавить карточку в колонку
         */
        else if ( e.target.classList.contains('btn-add-card') ) {
            let columnId = e.target.dataset.columnId,
                title = document.querySelector(`#column-${ columnId } .column-footer textarea`).value;

            document.querySelector(`#column-${ columnId } .form-add-card`).style.display = 'none';
            document.querySelector(`#column-${ columnId } .btn-open-form-add-card`).style.display = 'block';

            $.request('onCreateCard', {
                loading: $.wn.stripeLoadIndicator,
                data: {
                    title: title,
                    column_id: columnId
                },
                success: function(data) {
                    document.querySelector(`#column-${ columnId } .column-cards`).insertAdjacentHTML('beforeend', data.result);

                    document.querySelector(`#column-${ columnId } .column-footer textarea`).value = '';
                }
            });
        }

    });

    board.addEventListener('dblclick', e => {

        console.log(e.target);

        /**
         * Редактирование названия колонки // TODO 
         */
        if ( e.target.classList.contains('column-name') ) {
            console.log(e.target.textContent);

            let origName = e.target.textContent;

            let form = document.createElement('textarea');
            form.value = e.target.textContent;

            e.target.replaceWith(form); // –- заменяет node заданными узлами или строками.
            // form.select(); // Установить фокус и выделить текст
            form.focus(); // Просто установить фокус

            form.addEventListener('blur', () => {
                let div = document.createElement('div');
                div.classList.add('column-name');
                div.textContent = form.value;

                if (origName !== form.value) {
                    $.request('onEditColumnName', {
                        loading: $.wn.stripeLoadIndicator,
                        data: {
                            name: form.value,
                            column_id: form.parentElement.dataset.columnId
                        },
                        success: function(data) {
                            form.replaceWith(div);
                        }
                    })
                }
                else {
                    form.replaceWith(div);
                }
            });

        }
    })

    /**
     * Переключение тёмная/светлая тема - плагин DarkBackend
     */
     const callback = function(mutationsList, observer) {
        for (let mutation of mutationsList) {
            if (mutation.type === 'attributes') {
                let pathCSS = window.location.origin + '/plugins/webvpf/todoboard/assets/css/prism-',
                    linkCSS = document.querySelector(`link[href^="${ pathCSS }`),
                    pluginVersion = linkCSS.getAttribute('href').split('?')[1];

                linkCSS.setAttribute('href',
                    `${ pathCSS }${ mutation.target.classList.contains('dark') ? 'tomorrow' : 'solarizedlight'}.css?${ pluginVersion }`
                );
            }
        }
    }

    const observer = new MutationObserver(callback);
    observer.observe(document.querySelector('body'), { attributes: true });

});
