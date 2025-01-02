
$.showAlter=function(contentText='',imgBase64=''){
  $('#alter-bg').css('display','block');
  $("#alter-content-text").html(contentText);
  $("#alter-content-img").attr("src", `data:image/png;base64,${imgBase64}`);
}
$(function () {
  $('#version').html(jme.version)
  $("#alter-close-button,#alter-bg").bind('click', function () {
    $('#alter-bg').css('display','none');
  })
  $('#openTestURL').bind('click', function () {
    const nav = document.getElementById("nativeNav")
    const cookie = document.getElementById("needCookie")

    const useNav = nav.checked ? '1' : '0'
    const needCookie = cookie.checked ? '1' : '0'

    const x = document.getElementById("testURL")
    const urlStr = 'jdme://jm/biz/appcenter/201907150549' + '?nav=' + useNav + '&cookie=' + needCookie + '&url=' + x.value
    jme.browser.openUrl({
      type: 3,
      isHideNaviBar: nav.checked,
      url: urlStr
    });
  })
  $('#AllowedLeftEdge').bind('click', function () {
    const x = document.getElementById("AllowedLeftEdgeInput")
    alert(x.value);
    jme.browser.setPopAllowedLeftEdge({
      persent: x.value
    });
  })
  $('#deviceInfo').bind('click', function () {
    const result = jme.device.getDeviceInfo();
    alert(JSON.stringify(result));
  })
  $('#appletInfo').bind('click', function () {
    const result = jme.applet.getAppInfo();
    alert(JSON.stringify(result));
  })
  $('#getH5AppInfo').bind('click', function () {
    jme.applet.getH5AppInfo({
      appId: "201908080584",
      callback:function(data) {
        alert(JSON.stringify(data));
        }
      });
  })
  $('#sendEvent').bind('click', function () {
    console.log("sendEvent");
    var options = {
        appId: '2010923949',
        eventId:'JSSKD_EVENT_PAGE_UPDATE',
        data:{'a':'123'},
        callback: function(res) {
            alert(JSON.stringify(res));
        }
    }
    jme.event.sendEvent(options);
  });

  $('#shooting').bind('click', function () {
    jme.camera.openCamera(function (obj) {
      alert(JSON.stringify(obj));
    })
    // const param = {
    //   callback: function(data){
    //     alert(JSON.stringify(data));
    //   }
    // }
    // jme.camera.openCameraEx(param);
  })
  $('#openCameraEx').bind('click', function () {
    const param = {
      callback: function (data) {
        alert(JSON.stringify(data));
      }
    }
    jme.camera.openCameraEx(param);
  })
  $('#chooseAlbum').bind('click', function () {
    jme.album.chooseImage({
      multiple: false,
      success: function (obj) {
        alert(JSON.stringify(obj));
      }
    })
  });
  $('#chooseAlbums').bind('click', function () {
    jme.album.chooseImage({
      multiple: true,
      count: 3,
      success: function (obj) {
        alert(JSON.stringify(obj));
      }
    })
  });

  $('#saveImage').bind('click', function () {
    const inputImage = document.getElementById('saveImageInput');
    if(!inputImage.value){
      alert('请先获取Base64图片');
      return;
    }
    jme.album.saveImage({
      image: inputImage.value,
      imageName: "test.jpg",
      callback: function (obj) {
        console.log("saveImage callback：", obj);
        alert(JSON.stringify(obj));
      }
    })
  });

  $('#hideNavigationBar').bind('click', function () {
    jme.browser.setNaviBarHidden(true);
  })
  $('#showNavigationBar').bind('click', function () {
    jme.browser.setNaviBarHidden(false);
  })

  $('#showNaviBarCloseButton').bind('click', function () {
    let selectType = $("#showNaviBarCloseButtonSelect option:selected").val();
    jme.browser.showNaviBarCloseButton({showCloseButton:'true' == selectType});
    console.log('selectType:','true' == selectType);
  })
  $('#closeWeb').bind('click', function () {
    jme.browser.closeWeb();
  })
  $('#goback').bind('click', function () {
    jme.browser.goback();
  })
  $('#reload').bind('click', function () {
    jme.browser.refreshWeb();
  })
  $('#goForward').bind('click', function () {
    jme.browser.forward();
  })
  $('#error').bind('click', function () {
    jme.browser.showError({
      errCode: 1,
      message: '111'
    });
  })
  $('#resetSysMenu').bind('click', function () {
    jme.browser.resetSysMenu({
      menuList:['cut','copy','paste','select','selectAll','delete','search','comment','insertLink'],
      callback: function(res){
        alert(JSON.stringify(res));
      }
    });
  })
  $('#setScrollDisabled').bind('click', function () {
    let status = false;
    if ($("#setScrollDisabled").is(':checked')) {
      console.log("在ON的状态下");
      status = true;
    } else {
      status = false;
      console.log("在OFF的状态下");
    }
    jme.browser.setScrollDisabled({
      disabled: status,
    });
  })
  $('#setAllowsBackForwardNavigationGestures').bind('click', function () {
    let status = true;
    if ($("#setAllowsBackForwardNavigationGestures").is(':checked')) {
      console.log("在ON的状态下");
      status = true;
    } else {
      status = false;
      console.log("在OFF的状态下");
    }
    jme.browser.setAllowsBackForwardNavigationGestures({
      allow: status,
    });
  })
  $('#openUrl').bind('click', function () {
    const inputUrl = document.getElementById("browserOpenUrlInput");
    jme.browser.openUrl({
      type: 1,
      url: inputUrl.value
    });
  })
  $('#openSafariUrl').bind('click', function () {
    const urlInput = document.getElementById('openSafariUrlInput');
    jme.browser.openSafariUrl({
      url: urlInput.value,//'http://www.sina.com'
    });
  })
  // $('#openLocalUrl').bind('click', function () {
  //   jme.browser.openUrl({
  //     type: 2,
  //     url: 'index1.html'
  //   });
  // })
  $('#openDeepLink').bind('click', function () {
    // const url = 'jdme://jm/sys/browser?maction=openUrl&mparam=%7b%22url%22%3a%22http%3a%2f%2fwww.baidu.com%22%2c%22isHideNaviBar%22%3a1%2c%22isHideShareButton%22%3a0%7d';
    // alert(url);
    const urlInput = document.getElementById('openDeepLinkInput');
    alert(urlInput.value);
    jme.browser.openUrl({
      type: 3,
      isHideNaviBar:false,
      url: urlInput.value,
    });
  })
  $('#callDeepLink').bind('click', function () {
    // const url = 'jdme://jm/sys/browser?maction=openUrl&mparam=%7b%22url%22%3a%22http%3a%2f%2fwww.baidu.com%22%2c%22isHideNaviBar%22%3a1%2c%22isHideShareButton%22%3a0%7d';
    const urlInput = document.getElementById('callDeepLinkInput');
    jme.browser.callDeepLink({
      url: urlInput.value,
      callback: function (result) {
        alert(JSON.stringify(result));
      }
    });
  })
  // $('#openSafariUrl').bind('click', function () {
  //   jme.browser.openUrl({
  //     type: 4,
  //     url: 'http://www.hao123.com'
  //   });
  // })
  $('#setShareButtonHidden').bind('click', function () {
    jme.browser.setShareButtonHidden();
  })
  $('#setShareButtonShow').bind('click', function () {
    jme.browser.setShareButtonShow();
  })
  // $('#clearCache').bind('click', function () {
  //   const param = {
  //     callback: function (res) {
  //       alert(JSON.stringify(res));
  //     }
  //   }
  //   jme.browser.clearCache(param);
  // })
  $('#setGoBackDisabled').bind('click', function () {
    let status = false;
    if ($("#setGoBackDisabled").is(':checked')) {
      console.log("在ON的状态下");
      status = true;
    } else {
      status = false;
      console.log("在OFF的状态下");
    }
    const param = {
      disabled: status,
      callback: function (data) {
      }
    }
    jme.browser.setGoBackDisabled(param);
  })
  $('#keyboardChange').bind('click', function () {
    jme.browser.onKeyboardHeightChange({
      change: function (data) {
        $('.keyboard').html(`当前键盘高度${data.height}`);
      }
    })

  })
  const networkStatus = {
    0: "无网",
    1: 'wifi',
    2: 'WWAN',
    3: '2G',
    4: '3G',
    5: '4G',
    10: '移动网络'
  }
  $('#network').bind('click', function () {
    jme.network.getNetworkStatus(function (data) {
      alert(networkStatus[data.status]);
    })
  })
  $('#scan').bind('click', function () {
    const param = {
      // onlyFromCamera: true,
      // scanType: ['barCode', 'qrCode'],
      callback: function (data) {
        console.log("scanCodeEx callback:", data);
        alert(JSON.stringify(data));
      }
    }
    jme.scan.scanCodeEx(param);
  });
  $('#scanOCR').bind('click', function () {
    const options = {
      onlyFromCamera: true,
      scanType: ['document'],
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    }
    jme.scan.scanOCR(options);
  });
  $('#share').bind('click', function () {
    const param = {
      title: '通用分享功能',
      content: '我是通用分享的哈',
      url: 'http://www.jd.com',
      icon: 'https://ss0.baidu.com/6ONWsjip0QIZ8tyhnq/it/u=2920084749,2018893236&fm=58&s=39C718720E8EBE011B398BAC0300F024&bpow=121&bpoh=75'
    }
    jme.share.shareNormal(param, function (res) {
      alert(JSON.stringify(res));
    })
  })
  $('#shareCustomLabel').bind('click',function () {
    let selectType = $("#shareCustomSelect option:selected").val();
    if(selectType == 1){
      // 分享base64t图
      jme.album.getImageBase64({
        success: function (obj) {
          console.log('shareCustomInput obj',obj);
          $('#shareCustomInput').val(obj.base64);
        }
      })
    }else{
      // 分享url
    }
  });
  $('#shareCustomSelect').bind('change',function () {
    let selectType = $("#shareCustomSelect option:selected").val();
    console.log(`shareCustomSelect selectType：${selectType}`);
    $("#shareCustomLabel").html(selectType==1?'选择图片':'图片url：')
    $("#shareCustomInput").val(selectType==1?'':'https://menu.s3.cn-north-1.jdcloud-oss.com/login-pic.png')
  });
  $('#shareCustom').bind('click', function () {

    let imageInput = $("#shareCustomInput").val();
    if(!imageInput){
      alert('请先选分享图片！');
      return;
    }
    let typeList = [];
    $("input[name='shareCustomType']:checked").each(function(i){//把所有被选中的复选框的值存入数组
      typeList[i] =$(this).val();
    });
    console.log('typeList:',typeList);

    let param = {
      shareData: {
        title: '通用分享功能',
        content: '我是通用分享的哈',
        url: 'http://www.jd.com',
        icon: imageInput
      },
      typeList: typeList,
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    }
    let selectType = $("#shareCustomSelect option:selected").val();
    if(selectType==1){
      param = {
        shareData: {
          image: imageInput,
        },
        typeList: typeList,
        callback: function(res) {
          alert(JSON.stringify(res));
        }
      }
    }
    console.log(param);
    jme.share.shareCustom(param);
  });
  $('#shareSystemLabel').bind('click',function () {
    let selectType = $("#shareSystemSelect option:selected").val();
    if(selectType == 1){
      // 分享base64t图
      jme.album.getImageBase64({
        success: function (obj) {
          console.log('shareSystemInput obj',obj);
          $('#shareSystemInput').val(obj.base64);
        }
      })
    }else{
      // 分享本地url
      jme.album.chooseImage({
        multiple: false,
        success: function (obj) {
          const localUrl = obj["localUrl"];
          console.log('shareSystemLabel localUrl:',localUrl);
          $("#shareSystemInput").val(localUrl);
        }
      })
    }
  })
  $('#shareSystem').bind('click', function () {
    let imgUrl =  $("#shareSystemInput").val();
    if(!imgUrl){
      alert('请先选分享图片');
      return;
    }

    let param = {
      title: '通用分享功能',
      content: '我是通用分享的哈',
      imageUrl: imgUrl,
      shareUrl: 'https://ss0.baidu.com/6ONWsjip0QIZ8tyhnq/it/u=2920084749,2018893236&fm=58&s=39C718720E8EBE011B398BAC0300F024&bpow=121&bpoh=75',
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    }
    let selectType = $("#shareSystemSelect option:selected").val();
    if(selectType==1){
      param = {
        imageBase64: imgUrl,
        callback: function(res) {
          alert(JSON.stringify(res));
        }
      }
    }
    console.log(param);
    jme.share.shareSystem(param);
  });
  $('#showCustomMenu').bind('click', function() {
    var typeList = ["JDMESession",  "WXSession", "WXTimeline", "SMS", "CopyLink", "Browser"]
    var options = {
      shareData: {
          title: '通用分享功能',
          content: '我是通用分享的哈',
          url: 'http://www.jd.com',
          icon: 'https://ss0.baidu.com/6ONWsjip0QIZ8tyhnq/it/u=2920084749,2018893236&fm=58&s=39C718720E8EBE011B398BAC0300F024&bpow=121&bpoh=75'
      },
      typeList: typeList,
      callback: function(res) {
          alert(JSON.stringify(res));
      }}
    jme.share.showCustomMenu(options);
  })
  $('#eventCustom').bind('click', function () {
    const options = {
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    }
    jme.datacollection.eventCustom(options);
  })
  $('#eventPerformance').bind('click', function () {
    const options = {
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    }
    jme.datacollection.eventPerformance(options);
  })
  $('#eventPageView').bind('click', function () {
    const options = {
      pageID: 'test_collection_page_1',
      params: {
        duration: '10'
      },
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    }
    jme.datacollection.eventPageView(options);
  })
  $('#eventExposure').bind('click', function () {
    const options = {
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    }
    jme.datacollection.eventExposure(options);
  })
  $('#eventException').bind('click', function () {
    const options = {
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    }
    jme.datacollection.eventException(options);
  })
  $('#eventClick').bind('click', function () {
    const options = {
      eventID: 'collection_page_1582337867740|1',
      params: {
        erp: 'lijian584'
      },
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    }
    jme.datacollection.eventClick(options);
  })

  $('#setStorage').bind('click', function () {
    jme.storage.setStorage({
      key: "object",
      value: {
        "name": "隔壁老王",
        "age": "29",
        "type": "坏人"
      }
    })
  })
  $('#setStorageString').bind('click', function () {
    jme.storage.setStorage({
      key: "string",
      value: "我是字符串"
    })
  })
  $('#setStorageBoolean').bind('click', function () {
    jme.storage.setStorage({
      key: "boolean",
      value: true
    })
  })
  $('#getStorage').bind('click', function () {
    const data = jme.storage.getStorage({
      key: "object"
    });
    alert(JSON.stringify(data));
  })
  $('#getSrtingStorage').bind('click', function () {
    const data = jme.storage.getStorage({
      key: "string"
    })
    alert(data);
  })
  $('#getBooleanStorage').bind('click', function () {
    const data = jme.storage.getStorage({
      key: 'boolean'
    })
    alert(data);
  })
  $('#deleteStorage').bind('click', function () {
    jme.storage.removeStorage({
      key: "string"
    })
  })
  $('#clear').bind('click', function () {
    jme.storage.clearStorage();
  })
  $('#canOpenUrl').bind('click', function () {
    const inputUrl = document.getElementById("openUrlInput");
    const data = jme.applet.canOpenUrl(
      {
        url: inputUrl.value
        // 'https://www.jd.com'
      }
    );
    console.log("canOpenUrl is:", data);
    alert(JSON.stringify(data));
  })
  $('#openAppletUrl').bind('click', function () {
    const inputUrl = document.getElementById("openUrlInput");
    jme.applet.openAppletUrl({
      url: inputUrl.value,
      // 'itms-apps://itunes.apple.com/app/id414478124',
      success: function (data) {
        alert(JSON.stringify(data));
      }
    });
  })

  $('#openSetting').bind('click', function () {
    const options = {
      pageType: $("#openSettingSelect option:selected").val(),// 'pushEnable'/'keepAlive'
      enable:'true' === $("#openSettingEnable option:selected").val(),// true/false
      packageName:$("#openSettingPackageName").val(),
      className:$("#openSettingClassName").val(),
      callback: function(res) {
        alert(JSON.stringify(res));
      }
    }
    console.log('openSetting options:',options);
    jme.applet.openSetting(options);
  })

  $('#portrait').bind('click', function () {
    jme.screen.portrait();
  })
  $('#landscape').bind('click', function () {
    jme.screen.landscape();
  })
  $('#getJDPinToken').bind('click', function () {
    //const data = jme.user.getJDPinToken({
    jme.login.getJDPinToken({
      url: 'https://logistics-mrd.jd.com/express/index.html?source=jdMeAppPost',
      callback: function (data) {
        alert(JSON.stringify(data));
      }
    });
  })
  $('#getOTPSeed').bind('click', function () {
    // status 0 成功 1 失败
    // {"result":true,"status":"0"}
    const param = {
      callback: function (data) {
        alert(JSON.stringify(data));
      }
    }
    jme.login.getOTPSeed(param);
  })

  $('#getOTP').bind('click', function () {
    const param = {
      length: 6,
      callback: function (result) {
        alert(JSON.stringify(result));
      }
    };
    jme.login.getOTP(param);
  })

  $('#getAuthorizationCode').bind('click', function () {
    const param = {
      callback: function (result) {
        alert(JSON.stringify(result));
      }
    };
    jme.login.getAuthorizationCode(param);
  })

  $('#getAccountIdentifier').bind('click', function () {
    const param = {
      callback: function (result) {
        alert(JSON.stringify(result));
      }
    };
    jme.login.getAccountIdentifier(param);
  })
  $('#getAccountInfo').bind('click', function () {

    const param = {
      'applicationKey': 'VadzchmEZq2HQWLXeGuP',
      callback: function (result) {
        alert(JSON.stringify(result));
      }
    };
    jme.login.getAccountInfo(param);
  })
  $('#logout').bind('click', function () {
    const param = {
      callback: function (result) {
        alert(JSON.stringify(result));
      }
    };
    jme.login.logout(param);
  })
  $('#getImageBase64').bind('click', function () {
    jme.album.getImageBase64({
      success: function (obj) {
        alert(JSON.stringify(obj.base64));
        console.log('getImageBase64 obj',obj);
        $('#saveImageInput').val(obj.base64);
      }
    })
  })
  $('#sendShareCardMessage').bind('click', function () {
    const session = {
      app: 'ee',
      pin: 'caiyue19',
      type: 1,
      isSecret: false
    }

    const param = {
      session: session,
      url: 'https://joyspace-pre.jd.com/page/TIaX7cdJdbSAlRU_Sp09?jdme_router=jdme%3A%2F%2Fweb%2F201906270537%3Fbrowser%3D1%26url%3Dhttps%253A%252F%252Fjoyspace-pre.jd.com%252Fpage%252FTIaX7cdJdbSAlRU_Sp09',
      title: '测试用',
      content: '123123',
      icon: 'https://storage.jd.com/hub-static/icons/doc-icon.png',
      source: 'JoySpace',
      sourceIcon: 'https://joyspace-pre.jd.com/static/favicon.ico',

      callback: function (res) {
        alert(JSON.stringify(res));
      }
    }
    jme.im.sendShareCardMessage(param);
  })
  $('#openContactSelector').bind('click', function () {
    const selectedList = [
      {erp: 'lijian584', appid: '111'},
      {erp: 'tianheng', appid: '222'},
      {erp: 'qiaoxiaozhong', appid: '333'}
    ]
    const param = {
      selected: selectedList,
      title: '测试联系人',
      maxNum: 50,

      callback: function (res) {
        alert(JSON.stringify(res));
      }
    }
    jme.im.openContactSelector(param)
  })
  $('#openContactsSelector').bind('click', function () {
    const contactsList = [
      {name: "李健", appId: "1000", teamId: "1", userId: "qH662MKkPxn80eNy8jnNO", avatar: "", fixed: true},
      {name: "陈军", appId: "1000", teamId: "1", userId: "djd4ZkMMhMySsw8KWiAkZ", avatar: ""},
      {name: "乔小众", appId: "1000", teamId: "1", userId: "cDBSV9fJWezEv1z2J9cuI", avatar: ""}
    ]
    const options = {
      title: '联系人选择',
      action: 0,
      actionText: '确定',
      multiselect: true,
      maxNumber: 3,
      contactsList: contactsList,
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    }
    jme.im.openContactsSelector(options)
  })
  $('#openContactsSelectorPro').bind('click', function () {
    const contactsList = [
      {name: "李健", appId: "1000", teamId: "1", userId: "lijian584", avatar: "", fixed: true},
      {name: "陈军", appId: "1000", teamId: "1", userId: "chenjun288", avatar: ""},
      {name: "乔小众", appId: "1000", teamId: "1", userId: "qiaoxiaozhong", avatar: ""}
    ]
    const options = {
      title: '联系人选择',
      action: 0,
      actionText: '确定',
      multiselect: false,
      maxNumber: 3,
      contactsList: contactsList,
      callback: function (res) {
        alert(JSON.stringify(res));
        const contactsList =  res["contactsList"];
        const person = contactsList&&contactsList[0];
        $("#openContactsCardInput").val(JSON.stringify(person));
        console.log('openContactsSelectorPro person:',person);
      }
    }
    jme.im.openContactsSelectorPro(options)
  })
  $('#openContactsCard').bind('click', function () {
    const contact =  $("#openContactsCardInput").val();
    if(!contact) {
      alert('请先用openContactsSelectorPro选择联系人');
      return;
    }
    const options = {
      ...JSON.parse(contact),
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    }
    console.log('openContactsCard options:',options);
    jme.im.openContactsCard(options)
  })
  $('openSingleChat').bind('click', function() {
    const options = {
      appId:'ee',
      userId:'lijian584',
      callback:function(res){
          alert(JSON.stringify(res));
      }
  }
    jme.im.openSingleChat(options)
  })
  $('openGroupChat').bind('click', function() {
    const options = {
      groupId:'138398743202',
      callback:function(res){
          alert(JSON.stringify(res));
      }
  }
  jme.im.openGroupChat(options)
  })
  $('openCreateGroupChat').bind('click', function() {
    var members = [
      {name:"李健",appId:"ee",teamId:"1",userId:"lijian584",avatar:""},
      {name:"陈军",appId:"ee",teamId:"1",userId:"chenjun288",avatar:""},
      {name:"乔小众",appId:"ee",teamId:"1",userId:"qiaoxiaozhong",avatar:""},
      {name:"张琪", appId:"ee",teamId:"1",userId:"zhangqi867",avatar:""}
    ]
    const options = {
        members:members,
        groupName:'测试群',
        groupType:0,
        appId:'2020102903',
        callback:function(res){
            alert(JSON.stringify(res));
        }
    }
    jme.im.openGroupChat(options)
  })
  $('#startSpeechRecognition').bind('click', function () {
    const param = {
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    }
    jme.speechrecognition.startSpeechRecognition(param);
  })
  $('#getUserInfo').bind('click', function () {
    const info = jme.user.getUserInfo();
    JSON.stringify(info);
  })
  $('#getFileData').bind('click', function () {
    const url = document.getElementById('getFileDataInput');
    const params = {
      filePath: url.value,//'file://JDMEApp/ThirdParty/Librarys/JDReact.bundle',
      format: 'base64',
    }
    const info = jme.file.getFileData(params);
    alert(JSON.stringify(info));
  })
  $('#chooseFile').bind('click', function () {
    const params = {
      count: '2',
      type: 'all',
      // extension:[''],
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    }
    jme.file.chooseFile(params);
  })
  $('#saveFile').bind('click', function () {
    const typeList = [
      'LocalFile', 'JDJPan'
    ];
    const options = {
      'downloadUrl': 'http://148.70.122.114:8089/webapp/0.0.4.2/Doc.md',
      'filePath': 'localhost://127.0.0.1/webapp/0.0.4.2/Doc.md',
      'name': 'JSSDK文档',
      'size': 29708,
      'type': 'md',
      'saveTypeList': typeList,
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    };
    jme.file.saveFile(options);
  })
  $('#openChat').bind('click', function () {
    const params = {
      userNames: ['lijian584', 'chenjun288', 'chuliangwu'],
      content: {},
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    }
    jme.im.openChat(params);
  })
  $('#uploadFile').bind('click', function () {
    const params = {
      filePath: '/Users/erp/JDWork/jssdk/jssdk.md',
      // needAuthn:true,
      // needCdn:false,
      // ossBucketName:'',
      callback: function (res) {
        // const mparam = {
        //     statusCode:0,
        //     fileDownloadUrl:'http://download.jd.com/aaa.dat',
        //     uploadId:'749879284',
        //     fileMd5:'dc1a813c70c94e3e016922e149d96e3a859d34eb'
        // };
        alert(JSON.stringify(res));
      }
    }
    jme.network.uploadFile(params);
  })
  $('#downloadFile').bind('click', function () {
    const params = {
      downloadUrl: 'http://148.70.122.114:8089/webapp/0.0.4.2/Doc.md',
      filePath: '',
      header: {},
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    }
    jme.network.downloadFile(params);
  })

  $('#openDocument').bind('click', function () {

    const url = document.getElementById("documentUrl")
    const params = {
      'downloadUrl': url.value,
      'filePath': url.value,//'localhost://127.0.0.1/webapp/0.0.4.2/Doc.md'
      'name': 'JSSDK文档',
      'size': 29708,
      'type': 'md',
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    };
    // alert(JSON.stringify(params));
    jme.file.openDocument(params);
  })

  $('#chooseFileFromJS').bind('click', function () {

    const url = document.getElementById("chooseFileFromJSInput")
    const params = {
      fileList:JSON.parse(url.value),
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    };
    console.log('jme.file.chooseFileFromJS:',params)
    jme.file.chooseFileFromJS(params);
  })

  $('#testUniversalLink').bind('click', function () {
    const url = document.getElementById("universalLink")
    alert(url.value);
    location.href = url.value;
    // location.href = 'http://k.sohu.com/static/pc/3.2/images/logo.jpg?t=20191210121006';
  })

  $('#authentication').bind('click', function () {
    const params = {
      authModes: ['facial'],
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    };
    jme.device.authentication(params);
  })
  $('#getFacialImage').bind('click', function () {
    const params = {
      actionContent: $("#getFacialImageSelect option:selected").text(),
      actionOptional: $("#getFacialImageSelect option:selected").val(),//0:左右摇头 1:上下摇头 2:张嘴 3:眨眼睛
      callback: function (res) {
        // alert(JSON.stringify(res));
        $.showAlter(res,res['image']);
      }
    };
    console.log('getFacialImage params:',params);
    jme.device.getFacialImage(params);
  })
  $('#scanQRCode').bind('click', function () {
    const options = {
      imgUrl: 'https://pics3.baidu.com/feed/0eb30f2442a7d93346846fcad868f91573f00100.jpeg?token=ec13b5b271641c01f20e57493ba8a025&s=FB906989066373190C1441D00300F0B2',
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    }
    const info = jme.image.scanQRCode(options);
  })
  $('#saveToPhotoAlbumBtn').bind('click', function () {
    console.log('saveToPhotoAlbumImg ');
    jme.album.chooseImage({
      multiple: false,
      success: function (obj) {
        const localUrl = obj["localUrl"];
        console.log('saveToPhotoAlbumImg localUrl:',localUrl);
        $("#saveToPhotoAlbumImg").val(localUrl);
      }
    })
  })
  $('#saveToPhotoAlbum').bind('click', function () {
    const imgSrc =  $("#saveToPhotoAlbumImg").val();
    if(!imgSrc){
      alert('请先选择图片');
      return;
    }
    const options = {
      filePath:imgSrc,
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    }
    jme.image.saveToPhotoAlbum(options);
  })

  $('#startLocationUpdate').bind('click', function () {
    const options = {
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    }
    jme.location.startLocationUpdate(options);
  })
  $('#stopLocationUpdate').bind('click', function () {
    const options = {
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    }
    jme.location.stopLocationUpdate(options);
  })
  $('#getLocation').bind('click', function () {
    const options = {
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    }
    jme.location.getLocation(options);
  })
  $('#goActivityWay').bind('click', function () {
    let options = {
      distance: 1000,
      latitude: 39.791486,
      longitude:116.570271,
      site:"地点名称",
      activitySite:"活动名称",
      bizName:"按钮名称",
      callback: function(res){
        console.log(' goActivityWay callback:',res);
        alert(JSON.stringify(res));
      }
    }
    jme.map.goActivityWay(options);
  })

  $('#startRecord').bind('click', function () {
    const options = {
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    }
    jme.voice.startRecord(options);
  })
  $('#stopRecord').bind('click', function () {
    const options = {
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    }
    jme.voice.stopRecord(options);
  })

  $('#openMeetingRoom').bind('click', function () {
    const options = {
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    }
    jme.meeting.openMeetingRoom(options);
  })
  $('#createMeeting').bind('click', function () {
    const options = {
      callback: function (res) {
        alert(JSON.stringify(res));
      }
    }
    jme.meeting.createMeeting(options);
  })
})
