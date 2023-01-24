document.addEventListener('DOMContentLoaded', () => {

    new Sortable(document.querySelector('#todo-board'), {
        group: 'columns',
        animation: 300,
        direction: 'horizontal',
        onEnd: function (e) {
            if (e.oldIndex != e.newIndex) {
                let dataSort = new Object();

                document.querySelectorAll('.board-column').forEach((column, index) => {
                    let columnId = column.id.replace('column-', '');
                    dataSort[columnId] = index + 1;
                });

                $.request('onSortColumn', {
                    loading: $.wn.stripeLoadIndicator,
                    data: {
                        data_sort: dataSort
                    },
                    error: function(jqXHR, status) {

                    }
                });
            }
        }
    });

    document.querySelectorAll('.column-cards').forEach(columnCard => {
        new Sortable(columnCard, {
            group: 'cards',
            animation: 150,
            onEnd: function (e) {

                /**
                 * Из одной колонки в другую
                 */
                if (e.to !== e.from) {
                    let columnIdTo = e.to.id.replace('cards-column-', ''),
                        columnIdFrom = e.from.id.replace('cards-column-', '');

                    let dataSortFrom = new Object();
                    let dataSortTo = new Object();

                    e.from.querySelectorAll('.column-card').forEach((card, index) => {
                        let cardId = card.id.replace('card-', '');
                        dataSortFrom[cardId] = index + 1;
                    });

                    e.to.querySelectorAll('.column-card').forEach((card, index) => {
                        let cardId = card.id.replace('card-', '');
                        dataSortTo[cardId] = index + 1;
                    });

                    $.request('onSortCard2', {
                        loading: $.wn.stripeLoadIndicator,
                        data: {
                            card_id: e.item.id.replace('card-', ''),
                            column_id_to: columnIdTo,
                            column_id_from: columnIdFrom,
                            data_sort_from: dataSortFrom,
                            data_sort_to: dataSortTo
                        }
                    });
                }

                /**
                 * Внутри колонки
                 */
                else if (e.oldIndex != e.newIndex) {
                    let columnId = e.to.id.replace('cards-column-', ''),
                        dataSort = new Object();

                    e.to.querySelectorAll('.column-card').forEach((card, index) => {
                        let cardId = card.id.replace('card-', '');
                        dataSort[cardId] = index + 1;
                    });

                    // console.log(dataSort);

                    $.request('onSortCard', {
                        loading: $.wn.stripeLoadIndicator,
                        data: {
                            column_id: columnId,
                            data_sort: dataSort
                        }
                    })
                }

            }
        })
    })
});
