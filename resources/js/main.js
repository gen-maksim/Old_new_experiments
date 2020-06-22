Vue.component('trainings-list', {
    props: ['trainings', 'store-route'],

    template: `
        <table border="1">
            <caption>Зарегистрированные тренировки</caption>
            <th>Скалодром</th>
            <th>Дата</th>
            <th>Создатель</th>
            <th>Количество участников (зявок)</th>
            <th></th>
            <tr v-for="training in JSON.parse(trainings)">
                <training>{{ training.jym_name }}</training>
                <training>{{ training.start_datetime }}</training>
                <training>{{ training.owner_name }}</training>
                <training>{{ training.participants_progress }}</training>
                <training>
                    <form v-if="training.can_be_applied" method="post" :action="store-route">
                        <input type="hidden" name="training_id"  :value="training.id">
                        <button class="btn-sm" type="submit">Подать зявку на участие</button>
                    </form>
                    <div v-else>Вы уже подавали зявку или являетесь создателем</div>
                </training>
            </tr>
        </table>
    `,
})

Vue.component('training', {
    template: '<td><slot></slot></td>',
});

new Vue({
    el: '#trainings',
})