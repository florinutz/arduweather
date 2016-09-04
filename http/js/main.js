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
                if (data.advice) {
                    $('#advice').html('Please water plants.');
                } else {
                    $('#advice').html('No watering needed.');
                }
            }
        });
    }, $('body').data('refresh'));
});
