"use strict";

// /**Format Money */

function toMoney(ammount) {
    alert(ammount);
    ammount.toLocaleString('en-US', {
        style: 'currency',
        currency: 'IDR',
    })
}

function toMoney1(n, currency) {
    return currency + n.toFixed(2).replace(/./g, function (c, i, a) {
        return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
    });
}

function toMoney2(n, currency) {
    return currency + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
}

function toMoney3(n, currency) {
    return new Intl.NumberFormat('ru', {
        style: 'currency',
        currency: currency
    }).format(n);
}

/* Fungsi formatRupiah */
function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function thousands_separators(num) {
    var num_parts = num.toString().split(".");
    num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return num_parts.join(".");
}