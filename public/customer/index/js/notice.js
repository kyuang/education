 $('.swap').html($('.news_li').html());
        x = $('.news_li');
        y = $('.swap');
        h = $('.news_li li').length * 20; //20为每个li的高度
        var hh = $('.news_li li').length;
        if (hh > 1)
            //setTimeout(b,3000);//滚动间隔时间 现在是3秒
            b();
        b();

        function b() {
            t = parseInt(x.css('top'));
            //alert(t)
            y.css('top', '20px');
            x.animate({
                top: t - 20 + 'px'
            }, 'slow'); //20为每个li的高度
            if (Math.abs(t) == h - 20) { //20为每个li的高度
                y.animate({
                    top: '0px'
                }, 'slow');
                z = x;
                x = y;
                y = z;
            }
            setTimeout(b, 3000); //滚动间隔时间 现在是3秒
        }