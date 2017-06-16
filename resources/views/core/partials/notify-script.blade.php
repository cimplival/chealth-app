<script>

    phonon.options({
        navigator: {
            defaultPage: 'home'
        },
        i18n: null
    });

    phonon.navigator().on({page: 'home', content: null, readyDelay: 100}, function(activity) {

        activity.onCreate(function() {
            phonon.notif('#notify-chealth').show();
        });

    });

    phonon.navigator().start();

</script>