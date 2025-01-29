$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$(document).ready(function () {
    // $(document).on("click", ".user-list", function (e) {
    //     var getUserID = $(this).attr("data-id");
    //     var dataQuery = $(this).attr("data-query");
    //     receiver_id = getUserID;
    //     if (dataQuery == 0) {
    //         $(".chat-first-page").css("display", "none");
    //         loadChats();
    //     }
    // });

    // $(document).on("submit", "#chat-form", function (e) {
    //     e.preventDefault();

    //     var message = $("#user-chat").val();
    //     var receiver_id = $(".reciver_id").val();
    //     var url = "/user-chat";
    //     $.ajax({
    //         type: "POST",
    //         url: url,
    //         data: {
    //             _token: $("input[name=_token]").val(),
    //             message: message,
    //             reciver_id: receiver_id,
    //             sender_id: sender_id,
    //         },
    //         success: function (res) {
    //             if (res.success) {
    //                 $("#user-chat").val("");
    //                 let chat = res.chat.message;
    //                 let created_at = res.chat.created_at;
    //                 let time_format_12 = moment(
    //                     created_at,
    //                     "YYYY-MM-DD HH:mm:ss"
    //                 ).format("hh:mm A");
    //                 let profile_picture = res.sender_profile_picture;

    //                 let html =
    //                     `<div class="chat-sec-left chat-sec-right pb-1"><div class="chat-sec-left-wrap d-flex justify-content-end"><div class="chat-sec-left-text-box"><div class="chat-sec-left-text"><p>` +
    //                     chat +
    //                     `</p></div><div class="tm-div d-block pt-2 text-end"><h4>` +
    //                     time_format_12 +
    //                     `</h4></div></div></div></div>`;
    //                 if (res.chat_count > 0) {
    //                     $("#chat-container").append(html);
    //                     scrollChatToBottom();
    //                 } else {
    //                     $("#chat-container").html(html);
    //                 }
    //             } else {
    //                 console.log(res.msg);
    //             }
    //         },
    //     });
    // });

    // delete freind request
    // $(document).on("click", ".delete-btn", function (e) {
    //     e.preventDefault();
    //     var friendId = $(this).data("id");
    //     var url = "/doctor/reject-chat-request";
    //     $.ajax({
    //         type: "POST",
    //         url: url,
    //         data: {
    //             _token: $("input[name=_token]").val(),
    //             friendId: friendId,
    //         },
    //         success: function (res) {
    //             if (res.status == true) {
    //                 $("#friendProfile" + res.chatRequest.friend_id).remove();
    //                 const requestCount = $("#chat-count-" + res.chatRequest.user_id).text();
    //                 $("#chat-count-" + res.chatRequest.user_id).text(
    //                     parseInt(requestCount) - 1
    //                 );
    //             } else {
    //                 console.log(res.msg);
    //             }
    //         },
    //     });
    // });


});

// load chats
// function loadChats() {
//     $.ajax({
//         type: "POST",
//         url: "/doctor/load-chats",
//         data: {
//             _token: $("input[name=_token]").val(),
//             reciver_id: receiver_id,
//             sender_id: sender_id,
//         },
//         success: function (resp) {
//             if (resp.status == true) {
//                 $(".chat-module").html(resp.view);
//                 if (resp.chat_count > 0) {
//                     scrollChatToBottom();
//                 }

//             } else {
//                 console.log(resp.msg);
//             }
//         },
//     });
// }

// Echo.join("status-update")
//     .here((users) => {
//         for (let x = 0; x < users.length; x++) {
//             if (users[x].id != sender_id) {
//                 //   console.log(users[x].id + '--here');
//                 $("#" + users[x].id + "-status").addClass(
//                     "active-green set-active-green"
//                 );

//                 $("#" + users[x].id + "-userStatus").html(
//                     `<span class="online-user"></span>Online`
//                 );

//                 // add class in video call button

//             }
//         }
//     })

//     .joining((user) => {
//         // console.log(user + "--join");
//         $("#" + user.id + "-status").addClass("active-green set-active-green");
//         $("#" + user.id + "-userStatus").html(
//             `<span class="online-user"></span>Online`
//         );
//     })

//     .leaving((user) => {
//         // console.log(user + "--leave");
//         $("#" + user.id + "-status").removeClass(
//             "active-green set-active-green"
//         );
//         $("#" + user.id + "-userStatus").html(
//             `<span class="offline-user"></span>Offline`
//         );

//     })

//     .listen("UserStatusEvent", (e) => {
//         // console.log(e);
//     });

// get chat message
// Echo.private("broadcast-message").listen(".getChatMessage", (data) => {
//     // console.log(receiver_id);
//     let chat = data.chat.message;
//     let created_at = data.chat.created_at;
//     let time_format_12 = moment(created_at, "YYYY-MM-DD HH:mm:ss").format(
//         "hh:mm A"
//     );
//     let profile_picture = data.sender_profile_picture;
//     if (
//         data.chat.reciver_id == sender_id &&
//         receiver_id == data.chat.sender_id
//     ) {
//         let html =
//             `<div class="chat-sec-left pb-1"><div class="chat-sec-left-wrap d-flex"><div class="chat-sec-left-text-box"><div class="chat-sec-left-text"><p>` +
//             chat +
//             `</p></div><div class="tm-div d-block pt-2"><h4>` +
//             time_format_12 +
//             `</h4></div></div></div></div>`;
//         if (data.chat_count > 0) {
//             $("#chat-container").append(html);
//             scrollChatToBottom();
//         } else {
//             $("#chat-container").html(html);
//         }
//     }
// });

// get chat request
// Echo.private("user-request").listen(".getChatRequest", (data) => {
//     // console.log(data);
//     const doctor_id = data.friendRequest.user_id;
//     const patient_id = data.friendRequest.friend_id;
//     // console.log(sender_id, doctor_id, patient_id);
//     const requestCount = $("#chat-count-" + doctor_id).text();
//     if (sender_id == doctor_id) {
//         $("#chat-count-" + doctor_id).text(parseInt(requestCount) + 1);
//         $("#friendbox-" + doctor_id).prepend(
//             ` <div id="deletebtn" ></div> <div class="profile-div profile-div-2 profile-div-3 friend-request-div d-flex align-items-center justify-content-center" id="friendProfile` +
//             patient_id +
//             `" > <div class="profile-img"> <img src="` +
//             data.friendProfilePicture +
//             `" alt="" /> </div> <div class="profile-text"> <h2>` +
//             data.friendRequest.friend.name +
//             `</h2> </div> <div id="userId" ></div> <div class="confirm-btn" data-id="` +
//             data.friendRequest.id +
//             `"> <a href="javascript:void(0);"> <h4> <span><i class="fa-solid fa-check" id="acceptRequest"></i></span >Confirm </h4> </a> </div> <div class="delete-btn" data-id="` +
//             data.friendRequest.id +
//             `"> <a href="javascript:void(0);"> <h4> <span><i class="fa-solid fa-trash-can"></i></span> </h4> </a> </div> </div>`
//         );
//     }
// });

// accept chat request
// Echo.private("chat-request-accepted").listen(
//     ".getChatRequestAccepted",
//     (data) => {
//         const doctor_id = data.friend.user_id;
//         const chat = data.chat;
//         let created_at = data.chat.created_at;
//         let time_format_12 = moment(created_at, "YYYY-MM-DD HH:mm:ss").format(
//             "hh:mm A"
//         );
//         if (
//             data.chat.reciver_id == sender_id &&
//             receiver_id == data.chat.sender_id
//         ) {
//             let html =
//                 `<div class="container"> <div class="chat-sec-wrap"> <div class="chat-sec-box chat-srl_1 infinite-scroll" id="chat-container"> <div class="chat-sec-left pb-1"> <div class="chat-sec-left-wrap d-flex"> <div class="chat-sec-left-text-box"> <div class="chat-sec-left-text"> <p>` +
//                 chat.message +
//                 `</p> </div> <div class="tm-div d-block pt-2"> <h4>` +
//                 time_format_12 +
//                 `</h4> </div> </div> </div> </div> </div> <form action="javascript:void(0);" id="chat-form"> <input type="hidden" class="reciver_id" value="` +
//                 doctor_id +
//                 `" /> <div class="type-sec d-flex justify-content-center align-items-center"> <div class="type-div"> <div class="form-group"> <input type="text" class="form-control" id="user-chat" value="" placeholder="Type here..." required="" /> </div> </div> <div class="send-div"> <button type="submit" value="Submit"> <img src="/frontend_assets/images/send.png" alt="" /> </button> </div> </div> </form> </div> </div>`;
//             $("#chat-view").html(html);

//             console.log("accepted---" + data);
//         }
//     }
// );

// reject chat request
// Echo.private("reject-request").listen(".getRejectRequest", (data) => {
//     if (
//         data.chatRequest.friend_id == sender_id &&
//         receiver_id == data.chatRequest.user_id
//     ) {
//         $("#doctor-busy").html(
//             " <p>Medical Stuff Busy right now. Please try again latar</p> "
//         );
//         //   add id to send request button
//         $(".chat-request-button").attr("id", "send_request");
//         $("#send_request").val("Send Chat request");
//         console.log("reject---" + data);
//     }
//     console.log(data);
// });

// function scrollChatToBottom() {
//     var messages = document.getElementById("chat-container");
//     messages.scrollTop = messages.scrollHeight;
// }


// video call not started if patent offline
$(document).ready(function () {
    // $(document).on("click", ".video-call-deactive", function (e) {
    //     toastr.error("Patient is offline now. Please try again later");
    // });

    // $(document).on("click", ".video-call-active", function (e) {
    //     var receiver_id = $(this).attr("data-id");
    //     const id = sender_id;
    //     // loader
    //     $('#loading').addClass('loading');
    //     $('#loading-content').addClass('loading-content');
    //     $.ajax({
    //         type: "POST",
    //         url: "/doctor/video-call",
    //         data: {
    //             _token: $("input[name=_token]").val(),
    //             receiver_id: receiver_id,
    //             sender_id: id,
    //         },
    //         // loader: true,
    //         success: function (resp) {
    //             if (resp.status == true) {
    //                 // window.location.href = resp.meeting.data.start_url;
    //                 // open location in new tab
    //                 window.open(resp.meeting.data.start_url, '_blank');
    //                 $('#loading').removeClass('loading');
    //                 $('#loading-content').removeClass('loading-content');
    //             } else {
    //                 $('#loading').removeClass('loading');
    //                 $('#loading-content').removeClass('loading-content');
    //                 toastr.error(resp.message);
    //             }
    //         },
    //     });
    // });

    // $(document).on("click", ".pay-now", function (e) {
    //     var videocall_id = $(this).attr("data-id");
    //     var receiver_id = $(this).attr("data-receiverid");
    //     $.ajax({
    //         type: "POST",
    //         url: "/patient/open-pay-now-modal",
    //         data: {
    //             _token: $("input[name=_token]").val(),
    //             videocall_id: videocall_id,
    //         },
    //         success: function (resp) {
    //             if (resp.status == true) {
    //                 $("#zoom-payment-modal-" + receiver_id).html(resp.view);
    //                 $("#Modal1").modal("hide");
    //                 $("#Modal3").modal("show");
    //             } else {
    //                 toastr.error(resp.message);
    //             }
    //         },
    //     });
    // });
});


// video request listen
Echo.private("zoom-request").listen(".zoomRequest", (data) => {
    // call ajax to open modal
    // console.log(data);
    var videocall = data.videocall;
    $.ajax({
        type: "POST",
        url: "/patient/open-zoom-modal",
        data: {
            _token: $("input[name=_token]").val(),
            videocall: videocall,
        },
        success: function (resp) {
            if (resp.status == true) {
                $("#zoom-modal-" + videocall.receiver_id).html(resp.view);
                $("#Modal1").modal("show");
            } else {
                toastr.error(resp.message);
            }
        },
    });

});
