export default {
    formatDate(date) {
        const dt = new Date(date);

        var date = dt.getDate();
        var month = dt.getMonth();
        var daysDiff = new Date().getDate() - date;
        var monthsDiff = new Date().getMonth() - dt.getMonth();
        var yearsDiff = new Date().getFullYear() - dt.getFullYear();
        if (yearsDiff === 0 && daysDiff === 0 && monthsDiff === 0) {
            var h = dt.getHours() == 0 ? 12 : dt.getHours();
            var suffix = h >= 12 ? "PM" : "AM";
            return h + ":" + dt.getMinutes() + " " + suffix;
        } else if (yearsDiff === 0 && monthsDiff === 0 && daysDiff === 1) {
            return "Yesterday";
        } else if (
            yearsDiff === 0 &&
            monthsDiff === 0 &&
            daysDiff > 1 &&
            daysDiff <= 7
        ) {
            return this.getDay(dt.getDay());
        } else if (yearsDiff === 0 && monthsDiff != 0) {
            return this.getMonth(dt.getMonth());
        } else if (yearsDiff >= 1) {
            return this.getMonth(month) + " " + date + ", " + new Date(dt).getFullYear();
        } else {
            return month;
        }
    },
    getMonth(month) {
        var m = "";
        switch (month) {
            case 0:
                m = "January";
                break;
            case 1:
                m = "February";
                break;
            case 2:
                m = "March";
                break;
            case 3:
                m = "April";
                break;
            case 4:
                m = "May";
                break;
            case 5:
                m = "June";
                break;
            case 6:
                m = "July";
                break;
            case 7:
                m = "August";
                break;
            case 8:
                m = "September";
                break;
            case 9:
                m = "October";
                break;
            case 10:
                m = "Novermber";
                break;
            case 11:
                m = "December";
                break;
        }
        return m;
    },
    getDay(day) {
        var d = "";
        switch (day) {
            case 0:
                d = "Sunday";
                break;
            case 1:
                d = "Monday";
                break;
            case 2:
                d = "Tuesday";
                break;
            case 3:
                d = "Wednesday";
                break;
            case 4:
                d = "Thursday";
                break;
            case 5:
                d = "Friday";
                break;
            case 6:
                d = "Saturday";
                break;
        }
        return d;
    },
    formatTime(date) {
        const d = new Date(date);
        let hours = d.getHours();
        hours = hours < 10 ? "0" + (hours == 0 ? 12 : hours) : hours;
        let minuts = d.getMinutes();
        minuts = minuts < 10 ? "0" + minuts : minuts;
        let ampm = hours >= 12 ? "pm" : "am";
        return hours + ":" + minuts + " " + ampm;
    },
}
