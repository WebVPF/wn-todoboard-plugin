/**
 * Функция запускаемая при открытии модального окна с карточкой
 */
function cardInit() {
    Prism.highlightAll();
}

function highlightCode(selector) {
    document.querySelectorAll(`${selector} pre code`).forEach(el => Prism.highlightElement(el))
}

document.addEventListener('DOMContentLoaded', () => {

    document.addEventListener('click', (e) => {
        /**
         * Добавить новый комментарий к карточке
         */
        if (e.target.id === 'btn_create_comment') {
            let txtField = document.querySelector('#field_comment'),
                cardId = e.target.dataset.cardId;

            if (txtField.value.length > 0) {
                $.request('onCreateComment', {
                    loading: $.wn.stripeLoadIndicator,
                    data: {
                        content: txtField.value,
                        card_id: cardId
                    },
                    success: function(data) {
                        document.querySelector(`.card-comments`).insertAdjacentHTML('beforeend', data.result);

                        txtField.value = '';

                        let allComments = document.querySelectorAll('.comment');
                        allComments[allComments.length - 1].querySelectorAll('pre code').forEach(el => Prism.highlightElement(el)); // TODO
                        // document.querySelectorAll('.card-comments pre code').forEach(el => Prism.highlightElement(el)); // TODO

                        /**
                         * добавить +1 комментарий на карточку
                         */
                        let cardCountComments = document.querySelector(`#card-${ cardId } .count-comments`);

                        if (cardCountComments) {
                            cardCountComments.textContent = Number(cardCountComments.textContent) + 1; 
                        }
                        else {
                            let count = document.createElement('span');
                            count.classList.add('wn-icon-comment-o', 'count-comments');
                            count.textContent = '1';
                            
                            document.querySelector(`#card-${ cardId } .column-card-info`).append(count);
                        }
                    }
                });
            }

        }
    })

    document.addEventListener('dblclick', (e) => {

        /**
         * Редактирование названия карточки // TODO 
         */
        if (e.target.classList.contains('modal-title')) {
            let origName = e.target.textContent,
                cardId = e.target.dataset.cardId;

            let form = document.createElement('textarea');
            form.value = e.target.textContent;
            e.target.replaceWith(form);
            form.focus();

            form.addEventListener('blur', () => {
                let h2 = document.createElement('h2');
                h2.classList.add('modal-title');
                h2.textContent = form.value;

                if (origName !== form.value) {
                    $.request('onEditCardName', {
                        loading: $.wn.stripeLoadIndicator,
                        data: {
                            title: form.value,
                            card_id: cardId
                        },
                        success: function(data) {
                            form.replaceWith(h2);

                            document.querySelector(`#card-${ cardId } .column-card-title`).textContent = form.value;
                        }
                    })
                }
                else {
                    form.replaceWith(h2);
                }
            });
        }
    })

});
