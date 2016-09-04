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

                if (data.advice) {
                    $('#advice').html('Please water plants.');
                } else {
                    $('#advice').html('Not watering needed.');
                }

                $('#last-light > div').html(data.last_light.val);
                $('#last-ground-humidity > div').html(data.last_ground_humidity.val);
                $('#last-air-humidity > div').html(data.last_air_humidity.val);
                $('#last-temperature > div > span').html(data.last_temperature.val);
            }
        });
    }, $('body').data('refresh'));
});
