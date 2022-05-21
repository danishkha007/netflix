function volumeToggle(button){
    let muted=$(".previewVideo").prop("muted");
    $(".previewVideo").prop("muted",!muted);
    $(button).find('i').toggleClass('fa-volume-mute');
    $(button).find('i').toggleClass('fa-volume-up');

}

function previewVideoEnded(){
    $('.previewVideo').toggle();
    $('.previewImage').toggle();
}


let videoId=$(".watchContainer").data("videoid")
let email=$(".watchContainer").data("email")
const base_url='http://localhost/netflix/backend/ajax/'

function trackUserProgress(videoId,email,url){
    setStarterTimer(videoId,email,url);
    updateProgressTimer(videoId,email,url);


}

trackUserProgress(videoId,email,base_url);


function updateProgressTimer(videoId,email,url){
    addVideoDuration(videoId,email,url);

    let timer;
    $("video").on("playing",function(event){
        window.clearInterval(timer);
        timer=window.setInterval(function(){
            updateProgress(videoId,email,event.target.currentTime,url);
        },3000);
    })
    .on("ended",function(){
        watchVideoCompleted(videoId,email,url);
        window.clearInterval(timer);
    })
}

function addVideoDuration(videoId,email,url){
    
    $.post(url+"addVideoDuration.php",{videoId:videoId,email:email},function(data){
        
    })
}
function updateProgress(videoId,email,progress,url){
    $.post(url+"updateVideoDuration.php",{videoId:videoId,email:email,progress:progress},function(data){

    })
}
function watchVideoCompleted(videoId,email,url){
    $.post(url+"watchVideoCompleted.php",{videoId:videoId,email:email},function(data){

    })
}
function setStarterTimer(videoId,email,url){
    $.post(url+"getProgress.php",{videoId:videoId,email:email},function(data){
        if(isNaN(data)){
            alert(data);
            return;
        }

        $("video").on("canplay",function(){
            this.currentTime=data;
            $("video").off("canplay");
        })
    })
}

function restartVideo(){
    $("video")[0].currentTime=0;
    $("video")[0].play();
    $(".upNext").fadeOut();
}

function watchVideo(videoId){
    window.location.href='http://localhost/netflix/watch/'+videoId;
}

function showUpNext(){
    $(".upNext").fadeIn();
}

$(function(){
    let win=$(window);
    win.scroll(function(){
        if($(this).scrollTop()>$(".global-nav").height()){
            $(".global-nav").addClass('scrolled');
            $(".site-logo").addClass('scrolledLogo')
            
        }else{
            $(".site-logo").removeClass('scrolledLogo')
            $(".global-nav").removeClass('scrolled');
        }
    })
})
$(function(){
    let path=window.location.href;
    $('.nav-links li a').each(function(){
        if(this.href===path){
            $(this).parent().addClass('active');
        }
    })
})