$(document).on("click", "#updateButton", function() {
    $.ajax({
        url: '/update',
        success: function(data) {
            if (data.weather) {
                $("#weatherTable tbody").html('');
                $.each(data.weather, function(idx, weatherDay) {
                    var currentDayHtml = '<tr>';
                    currentDayHtml += '<td>' + weatherDay.date + '</td>';
                    currentDayHtml += '<td>' + (weatherDay.temp > 0 ? '+' : '') + Math.round(weatherDay.temp) + '</td>';
                    currentDayHtml += '<td>' + weatherDay.cloudinessPercent + '%</td>';
                    currentDayHtml += '</tr>';
                    $("#weatherTable tbody").append(currentDayHtml);
                });
                $('body').append("<br>Успешно обновлено<br>");
            }
        }
    })
});