$(function() {
    setInterval(function(){
        $.ajax({
            dataType: "json",
            url: '/refresh',
            success: function(data) {
                $('#tagh-top > span').html(data.today_average_ground_humidity);
                $('#tat-top > span').html(data.today_average_temperature);
                $('#yagh-top > span').html(data.yesterday_average_ground_humidity);
                $('#yat-top > span').html(data.yesterday_average_temperature);
                $('#wd-top > span').html(data.weather_description);

                $('#last-light > div').html(data.last_light.val);
                $('#last-ground-humidity > div').html(data.last_ground_humidity.val);
                $('#last-air-humidity > div').html(data.last_air_humidity.val);
                $('#last-temperature > div > span').html(data.last_temperature.val);

                if (data.advice) {
                    $('#advice').html('Please water the plant!');
                } else {
                    $('#advice').html('No watering needed, all good, phew!');
                }
            }
        });
    }, $('body').data('refresh'));
});
