$('#weeklyAssignmentDetailModal').on('shown.bs.modal', function () {
    var weekDate = getWeekDate(new Date());
    $("#weeklyDatePicker3").val(weekDate);
    $('#waDetail tbody').html('');

    generateWAdata();
})
