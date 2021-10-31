function AjaxRequest() {
    this.mRequest = this.getHttpRequest(), this.mHandlers = new Array;
    var e = this;
    this.mRequest.onreadystatechange = function() {
        if (void 0 != e.mHandlers[e.mRequest.readyState])
            for (i = 0; i < e.mHandlers[e.mRequest.readyState].length; i++) e.mHandlers[e.mRequest.readyState][i](e)
    }
}

function CoreDo(e, t) {
    var a = new AjaxRequest;
    if (a.mRequest) {
        "https:" == document.location.protocol ? e.indexOf("https:") > -1 || (e = "https://" + e) : e = "http://" + e, a.mFileName = e;
        var o = document.getElementById(t);
        a.mRequest.open("GET", e), a.mRequest.onreadystatechange = function() {
            4 == a.mRequest.readyState && 200 == a.mRequest.status && (o.innerHTML = a.mRequest.responseText)
        }
    }
    a.mRequest.send(null)
}

function httpshash() {
    return "http"
}

function WLTAjaxVideobox(e, t, a, o, n) {
    jQuery.ajax({
        type: "GET",
        url: e + "/?core_aj=1&action=ajaxvideobox&pid=" + t + "&f=" + a + "&t=" + o,
        success: function(e) {
            var a = document.getElementById(n);
            a.innerHTML = e, jQuery("#wlt_videobox_ajax_" + t + "_active video").mediaelementplayer({
                success: function(e) {
                    e.addEventListener("timeupdate", function() {
                        jQuery(".videotime" + t).val(e.currentTime), jQuery(".videotime" + t).trigger("change")
                    }, !1), e.addEventListener("ended", function() {
                        jQuery(".videonextup" + t).length && setTimeout(function() {
                            window.location.href = jQuery(".videonextup" + t).val()
                        }, 500)
                    })
                }
            })
        },
        error: function(e) {
            alert(e)
        }
    })
}

function WLTAddF(e, t, a) {
    jQuery.ajax({
        type: "GET",
        url: e + "/?core_aj=1&action=ListObject&postid=" + a + "&type=" + t,
        success: function(e) {
            var t = e.split("**");
            jQuery().toastmessage("showToast", {
                text: t[0],
                sticky: !0,
                position: "top-right",
                type: t[1],
                closeText: "",
                close: function() {
                    console.log("toast is closed ...")
                }
            })
        },
        error: function(e) {
            alert(e)
        }
    })
}

function ShowAdSearch(e, t) {
    CoreDo(e + "/?core_aj=1&action=showadvancedsearch", t)
}

function WLTSetImgText(e, t, a, o) {
    CoreDo(e + "/?core_aj=1&action=setimgtext&aid=" + t + "&txt=" + a, o)
}

function WLTSetFeatured(e, t, a, o) {
    jQuery(".table tr").removeClass("bs-callout"), CoreDo(e + "/?core_aj=1&action=setfeatured&pid=" + t + "&aid=" + a, o)
}

function WLTSetImgOrder(e, t, a, o, n) {
    CoreDo(e + "/?core_aj=1&action=setimgorder&aid=" + t + "&pid=" + a + "&txt=" + o, n)
}

function WLTEDITMEDIA(e, t, a) {
    jQuery.ajax({
        type: "POST",
        url: e,
        data: {
            core_aj: 1,
            wlt_ajax: "showmediabox",
            mid: t
        },
        success: function(e) {
            jQuery("#editmediabox").show(), jQuery("#" + a).html(e)
        },
        error: function(e) {
            alert(e)
        }
    })
}

function WLTSaveRating(e, t, a, o) {
    CoreDo(e + "/?core_aj=1&action=SaveRating&pid=" + t + "&value=" + a, o)
}

function WLTSaveUpRating(e, t, a, o) {
    CoreDo(e + "/?core_aj=1&action=SaveUpRating&pid=" + t + "&value=" + a, o)
}

function WLTUpdateUserField(l, t, c, a, o) {

    email = document.getElementById("delivery3").value;

    jQuery.ajax({
        type: "GET",
        url: l + "/?core_aj=1&action=UpdateUserField&id=" + t + "&value=" + c + "&em=" + email + '&ses=' + a,
        success: function(result) {

            jQuery("#wlt_paymentoptionsbox").show();

            jQuery("#savecommentsbutton").hide();

            jQuery('#' + o).html('');

        },
        error: function(error) {
            alert(error);
        }
    });

}

function WLTCatPrice(e, t, a) {
    CoreDo(e + "/?core_aj=1&action=CatPrice&cid=" + t, a)
}

function WLTCatPriceUpdate(e, t, a, o) {
    CoreDo(e + "/?core_aj=1&action=CatUpdatePrice&cid=" + t + "&p=" + a, o)
}

function WLTMailingList(e, t, a) {
    CoreDo(e + "/?core_aj=1&action=MailingList&eid=" + t, a)
}

function WLTMapData(e, t, a) {
    CoreDo(e + "/?core_aj=1&action=MapData&postid=" + t, a)
}

function WLTChangeMsgStatus(e, t, a) {
    CoreDo(e + "/?core_aj=1&action=ChangeMsgStatus&id=" + t, a)
}

function WLTValidateUsername(e, t, a) {
    CoreDo(e + "/?core_aj=1&action=ValidateUsername&id=" + t, a)
}

function WLTChangeState(e, t, a, o) {
    CoreDo(e + "/?core_aj=1&action=ChangeState&val=" + t + "&sel=" + o + "&div=" + a, a)
}

function ChangeSearchValues(e, t, a, o, n, r, i) {
    CoreDo(e + "/?core_aj=1&action=ChangeSearchValues&val=" + t + "&key=" + a + "&cl=" + o + "&pr=" + n + "&add=" + r, i)
}

function isValidEmail(e) {
    var t = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
    return t.test(e)
}

function WLTSaveSession(e, t) {
    CoreDo(e + "/?core_aj=1&action=SaveSession", t)
}

function TaxNewValue(e, t) {
    var a = prompt(t, "");
    null != a && jQuery("#" + e).append(jQuery("<option selected=selected></option>").attr("value", "newtaxvalue_" + a).text(a)).attr("selected", "selected")
}

function GMApMyLocation() {
    if ("undefined" == typeof google) {
        var e = document.createElement("script");
		
		// FIX FOR NEW GOOGLE MAPS KEY
		gapikey = jQuery('#newgooglemapsapikey').val();
	
        e.src = "https://maps.google.com/maps/api/js?callback=loadMyLocationReady&key=" + gapikey, document.getElementsByTagName("head")[0].appendChild(e)
    } else loadMyLocationReady()
}

function loadMyLocationReady() {
    setTimeout(function() {
        jQuery("body").trigger("gmap_location_loaded")
    }, 2e3)
}

function SaveMyMarker(e) {
    "" == marker && (marker = new google.maps.Marker({
        position: e,
        map: map1,
        draggable: !0,
        animation: google.maps.Animation.DROP
    })), google.maps.event.addListener(marker, "dragend", function(e) {
        document.getElementById("mylog").value = e.latLng.lng(), document.getElementById("mylat").value = e.latLng.lat(), SaveMyLocation(e.latLng), SaveMyMarker(e.latLng)
    }), marker.setPosition(e), jQuery("#savemylocationbox").show()
}

function SaveMyLocation(e) {
    var t = new google.maps.Geocoder;
    t && t.geocode({
        latLng: e
    }, function(e, t) {
        if (t == google.maps.GeocoderStatus.OK) {
            document.getElementById("myaddress").value = e[0].formatted_address;
            for (var a = 0; a < e[0].address_components.length; a++) {
                var o = e[0].address_components[a];
                switch (o.types[0]) {
                    case "street_number":
                        break;
                    case "route":
                        break;
                    case "locality":
                        break;
                    case "postal_code":
                        document.getElementById("myzip").value = o.short_name;
                        break;
                    case "administrative_area_level_1":
                        break;
                    case "administrative_area_level_2":
                        break;
                    case "administrative_area_level_3":
                        break;
                    case "country":
                        document.getElementById("myco").value = o.short_name
                }
            }
        }
    })
}

function getAddressLocation(e) {
    var t = new google.maps.Geocoder;
    t && t.geocode({
        address: e
    }, function(e, t) {
        t == google.maps.GeocoderStatus.OK && (SaveMyLocation(e[0].geometry.location, "no"), document.getElementById("mylog").value = e[0].geometry.location.lng(), document.getElementById("mylat").value = e[0].geometry.location.lat(), SaveMyMarker(e[0].geometry.location), map1.setZoom(9), map1.setCenter(e[0].geometry.location))
    })
}

function getCurrentLocation() {
    navigator.geolocation ? navigator.geolocation.getCurrentPosition(savePosition, positionError, {
        timeout: 1e4
    }) : jQuery(".wlt_mylocation").click()
}

function positionError(e) {
    var t = (e.code, e.message);
    console.log(t)
}

function savePosition(e) {
	
	// FIX FOR NEW GOOGLE MAPS KEY
	gapikey = jQuery('#newgooglemapsapikey').val();
		
    jQuery.getJSON("http://maps.googleapis.com/maps/api/geocode/json?latlng=" + e.coords.latitude + "," + e.coords.longitude + "&key=" + gapikey, {
        sensor: !1,
        latlng: e.coords.latitude + "," + e.coords.longitude
    }, function(t) {
        //console.log(t.results[0].formatted_address), jQuery("#myaddress").val(t.results[0].formatted_address);
        for (var a = 0; a < t.results[0].address_components.length; a++) {
            var o = t.results[0].address_components[a];
            switch (o.types[0]) {
                case "postal_code":
                    jQuery("#myzip").val(o.short_name);
                    break;
                case "country":
                    jQuery("#myco").val(o.short_name)
            }
        }
        jQuery("#mylog").val(e.coords.longitude), jQuery("#mylat").val(e.coords.latitude), document.mylocationsform.submit()
    }), console.log("Position Set:" + e.coords.longitude + ", " + e.coords.latitude)
}
AjaxRequest.prototype.addEventListener = function(e, t) {
    void 0 == this.mHandlers[e] && (this.mHandlers[e] = new Array), this.mHandlers[e].push(t)
}, AjaxRequest.prototype.getHttpRequest = function() {
    var e = new Array("MSXML2.XMLHTTP.5.0", "MSXML2.XMLHTTP.4.0", "MSXML2.XMLHTTP.3.0", "MSXML2.XMLHTTP", "Microsoft.XMLHTTP");
    if (null != window.XMLHttpRequest) return new XMLHttpRequest;
    for (i = 0; e.length > i; i++) try {
        return new ActiveXObject(e[i])
    } catch (t) {}
    return null
}, equalheight = function(e) {
    var t, a = 0,
        o = 0,
        n = new Array;
    jQuery(e).each(function() {
        if (t = jQuery(this), jQuery(t).height("auto"), topPostion = t.position().top, o != topPostion) {
            for (currentDiv = 0; currentDiv < n.length; currentDiv++) n[currentDiv].height(a);
            n.length = 0, o = topPostion, a = t.height(), n.push(t)
        } else n.push(t), a = a < t.height() ? t.height() : a;
        for (currentDiv = 0; currentDiv < n.length; currentDiv++) n[currentDiv].height(a)
    })
}, jQuery(document).ready(function() {
    jQuery("#wlt_search_tab1").on("click", function() {
        jQuery("#wlt_google_map_wrapper").hide(), jQuery(".wlt_search_results").addClass("list_style").removeClass("grid_style"), jQuery("#wlt_search_tab2").removeClass("active"), jQuery("#wlt_search_tab3").removeClass("active"), jQuery("#wlt_search_tab1").addClass("active"), jQuery(".item .thumbnail").removeAttr("style"), setTimeout(function() {
            jQuery(".itemdata .thumbnail").removeAttr("style")
        }, 2e3), setTimeout(function() {
            jQuery(".itemdata .itemdatawrap").removeAttr("style")
        }, 2e3), setTimeout(function() {
            jQuery(".itemdata").removeAttr("style")
        }, 2e3)
    }), jQuery("#wlt_search_tab3").on("click", function() {
        loadGoogleMapsApi(), jQuery("#wlt_search_tab1").removeClass("active"), jQuery("#wlt_search_tab2").removeClass("active"), jQuery("#wlt_search_tab3").addClass("active")
    }), jQuery("#wlt_search_tab2").on("click", function() {
        jQuery("#wlt_google_map_wrapper").hide(), jQuery(".wlt_search_results").removeClass("list_style").addClass("grid_style"), jQuery("#wlt_search_tab1").removeClass("active"), jQuery("#wlt_search_tab3").removeClass("active"), jQuery("#wlt_search_tab2").addClass("active"), setTimeout(function() {
            equalheight(".grid_style .thumbnail")
        }, 2e3), setTimeout(function() {
            equalheight(".grid_style .itemdatawrap")
        }, 2e3), setTimeout(function() {
            equalheight(".grid_style .itemdata")
        }, 2e3)
    }), jQuery(".wlt_runeditor").click(function() {
        var e = jQuery(this).attr("alt");
        jQuery.fn.editable.defaults.mode = "popup", jQuery("#" + e).editable(), jQuery("#" + e).unwrap()
    }), jQuery(".wlt_searchbox .wlt_button_search").click(function() {
        jQuery("#wlt_searchbox_form").submit()
    })
});
var marker = "",
    map1;
jQuery("body").bind("gmap_location_loaded", function() {
    if ("" != document.getElementById("mylog").value) var e = {
        center: new google.maps.LatLng(document.getElementById("mylat").value, document.getElementById("mylog").value),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        zoom: 7,
        panControl: !0,
        zoomControl: !0,
        scaleControl: !0
    };
    else var e = {
        center: new google.maps.LatLng(0, 0),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        zoom: 2,
        panControl: !0,
        zoomControl: !0,
        scaleControl: !0
    };
    map1 = new google.maps.Map(document.getElementById("wlt_google_mylocation_map"), e);
    var t = jQuery("#mylat").val();
    if ("" != t) {
        new google.maps.Marker({
            position: new google.maps.LatLng(jQuery("#mylat").val(), jQuery("#mylog").val()),
            map: map1,
            draggable: !0
        })
    }
    google.maps.event.addListener(map1, "click", function(e) {
        document.getElementById("mylog").value = e.latLng.lng(), document.getElementById("mylat").value = e.latLng.lat(), SaveMyLocation(e.latLng), SaveMyMarker(e.latLng)
    })
});