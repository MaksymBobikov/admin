import {DateTime} from "luxon";

const DATE_FORMAT = 'dd.LL.yyyy';

const DATETIME_FORMAT = 'dd.LL.yyyy HH:mm';

export const SQL_FORMAT = 'yyyy-LL-dd HH:mm';

export const dateService = {
    addPeriod(date, period, amount) {
        return date ? this.parse(date).plus({[period]: amount}).toFormat(DATE_FORMAT) : '';
    },

    subPeriod(date, period, amount) {
        return date ? this.parse(date).minus({[period]: amount}).toFormat(DATE_FORMAT) : '';
    },

    checkDate(value, format = null) {
        return value ? DateTime.fromFormat(value, format || DATE_FORMAT).isValid : false;
    },

    getDateFormat() {
        return DATE_FORMAT;
    },

    getCurrentDate() {
        return DateTime.now().toFormat(DATE_FORMAT)
    },

    getCurrentDateTime() {
        return DateTime.now().toFormat(DATETIME_FORMAT)
    },

    toFormat(date, startFormat = null, toFormat = null) {
        return date ? DateTime.fromFormat(date, startFormat || DATE_FORMAT).toFormat(toFormat || DATE_FORMAT) : '';
    },

    parse(date, startFormat = null) {
        return date ? DateTime.fromFormat(date, startFormat || DATE_FORMAT) : '';
    },

    isAfter(date1, date2) {
        return date1 && date2 && this.parse(date1) > this.parse(date2)
    },

    isAfterOrEqual(date1, date2) {
        return date1 && date2 && this.parse(date1) >= this.parse(date2)
    },

    isBefore(date1, date2) {
        return date1 && date2 && this.parse(date1) < this.parse(date2)
    },

    isBeforeOrEqual(date1, date2) {
        return date1 && date2 && this.parse(date1) <= this.parse(date2)
    },

    fromISOToFormat(date, format = null) {
        return date ? DateTime.fromISO(date, {setZone: true}).toFormat(format || DATETIME_FORMAT) : '';
    },

    fromISOToDateTime(date) {
        return date ? DateTime.fromISO(date, {setZone: true}) : '';
    },

    fromSQLToFormat(date, format = null) {
        return date ? DateTime.fromSQL(date).toFormat(format || DATETIME_FORMAT) : '';
    },

    fromSQLToDateTime(date) {
        return date ? DateTime.fromSQL(date) : '';
    },

    getNowDate(format = null) {
        return format ? DateTime.now().toFormat(format) : DateTime.now()
    },

    getStartOfYearDate() {
        return DateTime.now().startOf('year').toFormat(DATE_FORMAT)
    },
    getEndOfYearDate() {
        return DateTime.now().endOf('year').toFormat(DATE_FORMAT)
    },

    getStartOfMonthDate() {
        return DateTime.now().startOf('month').toFormat(DATE_FORMAT)
    },
    getEndOfMonthDate() {
        return DateTime.now().endOf('month').toFormat(DATE_FORMAT)
    },

    getStartOfWeekDate() {
        return DateTime.now().startOf('week').toFormat(DATE_FORMAT)
    },
    getEndOfWeekDate() {
        return DateTime.now().endOf('week').toFormat(DATE_FORMAT)
    },

    getStartOfDayDate() {
        return DateTime.now().startOf('day').toFormat(DATE_FORMAT)
    },
    getEndOfDayDate() {
        return DateTime.now().endOf('day').toFormat(DATE_FORMAT)
    },
}
