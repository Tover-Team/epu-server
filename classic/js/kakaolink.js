function kakaolink_send(text, url, img, img_w, img_h) {
	Kakao.Link.sendScrap({
		requestUrl: url
	});
}