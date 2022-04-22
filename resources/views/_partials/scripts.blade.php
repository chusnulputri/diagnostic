<script>
    const baseUrl = "{{ asset('') }}";

</script>

<script src="{{ asset('js/app.js') }}"></script>
<!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-app.js"></script>
<!-- Add Firebase products that you want to use -->
<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-messaging.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js"
    integrity="sha512-GMGzUEevhWh8Tc/njS0bDpwgxdCJLQBWG3Z2Ct+JGOpVnEmjvNx6ts4v6A2XJf1HOrtOsfhv3hBKpK9kE5z8AQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
     function humanizeDate(e, format = 'DD/MM/YYYY') {
        const formatOfDate = moment(e, ['YYYY-MM-DD', 'DD/MM/YYYY']).creationData().format;

        if (formatOfDate) {
            const data = moment(e, formatOfDate);

            if (data.isValid())
                return data.format(format)
        }

        return 'Unknown Format/Date';
    }
    function isJson(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }

    function readNotification(id, url, read) {
        window.open(
            url,
            '_blank' // <- This is what makes it open in a new window.
        );
        if (read == '1') {
            return false;
        }
        axios.post(
                "{{url('api/setting/notifications')}}/" +
                id + '/mark-as-read')
            .then((response) => {
                $('#' + id).css("background", "");
                $('.' + id).css("background", "");
                $('#notification-count-text').html(response.data.total_unread);
            }).catch((e) => {
                if (e.response && e.response.status == '401') {
                    window.location = '{{ Route("dashboard") }}'
                } else if (e.response && e.response.status ==
                    '400') {
                    toast(e.response.data.message, 'warning');
                } else {
                    toast('Failed request, please try again.',
                        'error');
                }
            }).then(() => {
            });
    }

    function getNotifDB() {
        axios.get("{{url('api/setting/notifications')}}")
            .then((response) => {
                console.log(response.data.data.data.length);
                let notifCount = response.data.total_unread;
                if (response.data.total_unread && parseInt(response.data.total_unread) > 99) {
                    notifCount = '99'
                }
                $('#notification-count-text').html(notifCount);

                if (response.data.data.data.length > 0) {
                    $('#empty-notification-nav').remove();
                }
                let htmlt = '';
                for (let i = 0; i < response.data.data.data.length; i++) {
                    if (i <= 4) {
                        let context = response.data.data.data[i];
                        let backgroundStyle = '';
                        let read = '1';
                        if (!context.read_at) {
                            backgroundStyle = 'background:#f9f9f9;';
                            read = '0';
                        }
                        let titleX = '';
                        let contentX = '';
                        let ago = moment(context.created_at).lang("id").fromNow()

                        let data = context.data;
                        titleX = data.title;
                        contentX = data.message;


                        htmlt += `<li class="c-pointer" onClick="readNotification('` + context.id + `','` +
                            data.url +
                            `','` + read + `')" id="` +
                            context.id + `" style="padding:5px;` + backgroundStyle + `">
                                    <div class="dropdown-messages-box">
                                        <div class="media-body">
                                            <small class="float-right">` + ago + `</small>
                                            <div style="font-weight:600;font-size:12px;">` + titleX + `</div>
                                            <div style="font-size:11px;color:#888888;" class="pt-1">` + contentX + `</div>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown-divider" style="margin:0 !important"></li>`;
                    }

                }
                if (response.data.data.data.length > 5) {
                    $('#more-nav-notification').removeClass('d-none');
                }
                if(response.data.data.data.length > 0){
                    $('#notification-body-nav').empty();
                }

                $('#notification-body-nav').append(htmlt);

            }).catch((e) => {
                console.log(e);
            });
    }

    $(".dropdown-menu").click(function (e) {
        e.stopPropagation();
    })

    let firebaseDatabase;
    let messaging;
    (function () {
        var config = {
            apiKey: "AIzaSyA1oboaLdQ6Z_I5WL57T_YJ2ZbyzC3X92I",

            authDomain: "general-projects-323509.firebaseapp.com",

            projectId: "general-projects-323509",

            storageBucket: "general-projects-323509.appspot.com",

            messagingSenderId: "764688620206",

            appId: "1:764688620206:web:f41c7a5ab58867b1a66b3f",

            measurementId: "G-85Q6YGJFSC"

        };

        firebase.initializeApp(config);

        messaging = firebase.messaging();

        messaging
            .requestPermission()
            .then(function () {
                return messaging.getToken()
            })
            .then(function (token) {
                console.log("SAVE TOKEN");
                console.log(token);
                axios.post(
                        "{{url('api/setting/notifications/save-token')}}", {
                            token: token
                        })
                    .then((response) => {
                        console.log('success saved');
                    }).catch((e) => {
                        if (e.response && e.response.status == '401') {

                        } else if (e.response && e.response.status ==
                            '400') {
                            toast(e.response.data.message, 'warning');
                        } else {
                            console.log(e);
                            toast('Failed request, please try again.',
                                'error');
                        }
                    });

            })
            .catch(function (err) {
                console.log("Unable to get permission to notify.", err);
            });

        messaging.onMessage(function (payload) {
            console.log("RECEIVED");
            const noteTitle = payload.notification.title;
            const noteOptions = {
                body: payload.notification.body,
                icon: payload.notification.icon,
            };

            new Notification(noteTitle, noteOptions);
            toast(noteTitle, 'info');
            getNotifDB();
        });
    })();

</script>

<script>
    function humanizePrice(alpha, withDigits = false) {

        if (!alpha)
            return '0.00';

        const separator = ',';
        const radix = '.'

        const data = parseFloat(alpha).toFixed(2);
        var val = data.toString().replace(/[^0-9.]/g, '');

        var parts = val.split('.');
        var result = parts.slice(0, -1).join('') + '.' + parts.slice(-1);
        result = result.replace(/^\./, '');
        result = result.replace(/\.$/, '');

        var bilangan = result.toString();
        var commas = (withDigits) ? '00' : '';

        if (bilangan.split('.').length > 1) {
            commas = bilangan.split('.')[1];
            bilangan = bilangan.split('.')[0];
        }

        var number_string = bilangan.toString(),
            sisa = number_string.length % 3;
        rupiah = number_string.substr(0, sisa);
        rupiah = isNaN(rupiah) ? '' : rupiah;
        ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            ult = sisa ? separator : '';
            rupiah += ult + ribuan.join(separator);
        }

        if (withDigits) {
            if (alpha.toString().charAt(0) == '-') {
                return '(' + rupiah + radix + commas + ')';
            }

            // Cetak hasil
            return rupiah + radix + commas // Hasil: 23.456.789
        } else {
            if (alpha.toString().charAt(0) == '-') {
                return '(' + rupiah + ')';
            }

            // Cetak hasil
            return rupiah // Hasil: 23.456.789
        }

    }


    function thousandsSeparators(value) {
        if (!value) {
            return '0';
        }

        value = parseFloat(value).toFixed(2).toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");

        if (value.split('.')[1] == '00') {
            return value.split('.')[0];
        }
        return value;
    };

</script>



@yield('extra_scripts')

<script>
    const notifSuccess = new Audio('{{ asset("sounds/success.mp3") }}');
    const notifError = new Audio('{{ asset("sounds/error.mp3") }}');
    const notifInfo = new Audio('{{ asset("sounds/info.mp3") }}');

    function toast(text, icon, timer = 5000, position = 'top-right', heading = null) {

        let bg = '#34495e';
        let textColor = 'white';

        if (icon == 'success') {
            bg = 'rgba(76, 175, 80, 1.0)';
        } else if (icon == 'error') {
            bg = 'rgba(233, 30, 99, 1.0)';
        } else if (icon == 'warning') {
            bg = 'rgba(251, 188, 4, 1.0)';
        }

        $.toast({
            heading: heading,
            text: text,
            position: position,
            stack: false,
            icon: icon,
            bgColor: bg,
            textColor: textColor,
            allowToastClose: false,
            hideAfter: timer,
            beforeShow: function () {
                if (icon == 'success')
                    notifSuccess.play();
                else if (icon == 'error')
                    notifError.play();
                else
                    notifInfo.play();
            }
        });
    }

    function terbilang(a) {
        var bilangan = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh',
            'Sebelas'
        ];

        // 1 - 11
        if (a < 12) {
            var kalimat = bilangan[a];
        }
        // 12 - 19
        else if (a < 20) {
            var kalimat = bilangan[a - 10] + ' Belas';
        }
        // 20 - 99
        else if (a < 100) {
            var utama = a / 10;
            var depan = parseInt(String(utama).substr(0, 1));
            var belakang = a % 10;
            var kalimat = bilangan[depan] + ' Puluh ' + bilangan[belakang];
        }
        // 100 - 199
        else if (a < 200) {
            var kalimat = 'Seratus ' + terbilang(a - 100);
        }
        // 200 - 999
        else if (a < 1000) {
            var utama = a / 100;
            var depan = parseInt(String(utama).substr(0, 1));
            var belakang = a % 100;
            var kalimat = bilangan[depan] + ' Ratus ' + terbilang(belakang);
        }
        // 1,000 - 1,999
        else if (a < 2000) {
            var kalimat = 'Seribu ' + terbilang(a - 1000);
        }
        // 2,000 - 9,999
        else if (a < 10000) {
            var utama = a / 1000;
            var depan = parseInt(String(utama).substr(0, 1));
            var belakang = a % 1000;
            var kalimat = bilangan[depan] + ' Ribu ' + terbilang(belakang);
        }
        // 10,000 - 99,999
        else if (a < 100000) {
            var utama = a / 100;
            var depan = parseInt(String(utama).substr(0, 2));
            var belakang = a % 1000;
            var kalimat = terbilang(depan) + ' Ribu ' + terbilang(belakang);
        }
        // 100,000 - 999,999
        else if (a < 1000000) {
            var utama = a / 1000;
            var depan = parseInt(String(utama).substr(0, 3));
            var belakang = a % 1000;
            var kalimat = terbilang(depan) + ' Ribu ' + terbilang(belakang);
        }
        // 1,000,000 -  99,999,999
        else if (a < 100000000) {
            var utama = a / 1000000;
            var depan = parseInt(String(utama).substr(0, 4));
            var belakang = a % 1000000;
            var kalimat = terbilang(depan) + ' Juta ' + terbilang(belakang);
        } else if (a < 1000000000) {
            var utama = a / 1000000;
            var depan = parseInt(String(utama).substr(0, 4));
            var belakang = a % 1000000;
            var kalimat = terbilang(depan) + ' Juta ' + terbilang(belakang);
        } else if (a < 10000000000) {
            var utama = a / 1000000000;
            var depan = parseInt(String(utama).substr(0, 1));
            var belakang = a % 1000000000;
            var kalimat = terbilang(depan) + ' Milyar ' + terbilang(belakang);
        } else if (a < 100000000000) {
            var utama = a / 1000000000;
            var depan = parseInt(String(utama).substr(0, 2));
            var belakang = a % 1000000000;
            var kalimat = terbilang(depan) + ' Milyar ' + terbilang(belakang);
        } else if (a < 1000000000000) {
            var utama = a / 1000000000;
            var depan = parseInt(String(utama).substr(0, 3));
            var belakang = a % 1000000000;
            var kalimat = terbilang(depan) + ' Milyar ' + terbilang(belakang);
        } else if (a < 10000000000000) {
            var utama = a / 10000000000;
            var depan = parseInt(String(utama).substr(0, 1));
            var belakang = a % 10000000000;
            var kalimat = terbilang(depan) + ' Triliun ' + terbilang(belakang);
        } else if (a < 100000000000000) {
            var utama = a / 1000000000000;
            var depan = parseInt(String(utama).substr(0, 2));
            var belakang = a % 1000000000000;
            var kalimat = terbilang(depan) + ' Triliun ' + terbilang(belakang);
        } else if (a < 1000000000000000) {
            var utama = a / 1000000000000;
            var depan = parseInt(String(utama).substr(0, 3));
            var belakang = a % 1000000000000;
            var kalimat = terbilang(depan) + ' Triliun ' + terbilang(belakang);
        } else if (a < 10000000000000000) {
            var utama = a / 1000000000000000;
            var depan = parseInt(String(utama).substr(0, 1));
            var belakang = a % 1000000000000000;
            var kalimat = terbilang(depan) + ' Kuadriliun ' + terbilang(belakang);
        }

        var pisah = kalimat.split(' ');
        var full = [];
        for (var i = 0; i < pisah.length; i++) {
            if (pisah[i] != "") {
                full.push(pisah[i]);
            }
        }
        return full.join(' ');
    }

    function logout(evt, flag, type = null) {

        evt.preventDefault();
        evt.stopImmediatePropagation();

        if (flag == 'execute') {

            if (type == 'company') {
                const confirm = document.getElementById('btn-konfirm-modal-logout-company');
                confirm.setAttribute("disabled", true);
                confirm.innerHTML = 'Logging Out. Harap Tunggu ...';
            } else {
                document.getElementById('btn-close-modal-logout').setAttribute('disabled', true);
                const confirm = document.getElementById('btn-konfirm-modal-logout');
                confirm.setAttribute("disabled", true);
                confirm.innerHTML = 'Logging Out. Harap Tunggu ...';
            }


            axios.post("{{ url('/api/auth/logout') }}")
                .then(response => {
                    location.reload();
                })
                .catch(e => {
                    if (e.response && e.response.status == '401') {
                        window.location = '{{ Route("dashboard") }}'
                    } else {
                        let message, title;

                        toast(message, e.response.data.status, 5000, 'top-right', title);
                    }

                    this.pageStatus = 'standby';
                    this.disabledButton = false;

                }).then(() => {
                    if (type == 'company') {
                        const confirm = document.getElementById('btn-konfirm-modal-logout-company');
                        confirm.removeAttribute("disabled");
                        confirm.innerHTML = 'Ya, logout akun saya';
                    } else {
                        document.getElementById('btn-close-modal-logout').removeAttribute('disabled');
                        const confirm = document.getElementById('btn-konfirm-modal-logout');
                        confirm.removeAttribute("disabled");
                        confirm.innerHTML = 'Ya, logout akun saya';
                    }
                });
        } else {
            $('#modal-logout').modal({
                backdrop: 'static',
                keyboard: false
            });
            // $('#modal-logout').modal('show');
        }

    }


    function unFormatDate(e, timestamp = false) {
        if (!e) {
            return '';
        }
        str = e.split(' ')[0];
        let date = str.split('/')[2] + '-' + e.split('/')[1] + '-' + e.split('/')[0];

        return date;
    }

    function showPopUpModal(evt, id = null) {
        const target = (!id) ? $(evt.target) : $('#' + id);
        const modal = target.closest('.modal');

        modal.find('.modal-content .secondPopUp').fadeIn('fast');

        setTimeout(() => {
            modal.find('.modal-content .secondPopUp .popUp-content').css('right', '0')
        }, 200);
    }

    function closePopUpModal(evt, id) {
        const target = (!id) ? $(evt.target) : $('#' + id);
        const modal = target.closest('.modal');

        modal.find('.modal-content .secondPopUp .popUp-content').css('right', '-350px')

        setTimeout(() => {
            modal.find('.modal-content .secondPopUp').fadeOut('fast');
        }, 200);
    }

</script>
