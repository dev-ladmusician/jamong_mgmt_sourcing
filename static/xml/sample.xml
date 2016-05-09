<krpano version="1.18" bgcolor="0x000000">
    <include url="../jamongplayer/skin/videointerface.xml" />
    <!-- include the videoplayer plugin and load the video (use a low res video for iOS) -->
    <plugin name="video"
            url.flash="%SWFPATH%/plugins/videoplayer.swf"
            url.html5="%SWFPATH%/plugins/videoplayer.js"
            videourl="http://ssproxy.ucloudbiz.olleh.com/v1/AUTH_b0ad3866-b002-4ec5-b1d9-7f221dd3417c/video_all/a482ducku83h72kxr_4k.mp4"
            pausedonstart="false"
            loop="true"
            volume="1.0"

            buffertime="0"


            onvideoplay=""
            onvideopaused=""
            onvideocomplete=""
            onerror=""

            onloaded="videointerface_setup_interface(get(name)); setup_video_controls();"
            onvideoready="videointerface_videoready();"

    />



    <!-- set the default view - a light fisheye projection -->
    <view hlookat="0" vlookat="0" fovtype="DFOV" fov="130" fovmin="75" fovmax="150" fisheye="0.35" />



    <!-- custom control setup - add items for selecting videos with a different resolution/quality -->
    <action name="setup_video_controls">
        <!-- add  items to the control menu of the videointerface skin -->


        <!-- select/mark the current video (see the initial videourl attribute) -->

    </action>


    <!-- change the video file, but try keeping the same playback position -->
    <action name="change_video_file">
        plugin[video].playvideo('%CURRENTXML%/%2', null, get(plugin[video].ispaused), get(plugin[video].time));

        videointerface_selectmenuitem(configmenu, %1);
    </action>




    <!-- the panoramic video image -->
    <image hfov="360" vfov="180">
        <sphere url="plugin:video" />
    </image>


</krpano>
