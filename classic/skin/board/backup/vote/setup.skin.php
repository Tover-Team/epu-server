<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 boset[배열키] 형태로 등록

if(!$boset['vstar']) $boset['vstar'] = 'crimson';

?>
<div class="tbl_head01 tbl_wrap">

	<p><b>■ 보드설정</b></p>
	<table>
	<caption>보드설정</caption>
	<colgroup>
		<col class="grid_2">
		<col>
	</colgroup>
	<thead>
	<tr>
		<th scope="col">구분</th>
		<th scope="col">설정</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td align="center">
			헤더출력
		</td>
		<td>
			<select name="boset[header_skin]">
				<option value="">사용안함</option>
				<?php
					$skinlist = get_skin_dir('header');
					for ($k=0; $k<count($skinlist); $k++) {
						echo "<option value=\"".$skinlist[$k]."\"".get_selected($skinlist[$k], $boset['header_skin']).">".$skinlist[$k]."</option>\n";
					} 
				?>
			</select>
			&nbsp;
			<select name="boset[header_color]">
				<?php echo apms_color_options($boset['header_color']);?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">목록링크</td>
		<td>
			<select name="boset[modal]">
				<option value=""<?php echo get_selected('', $boset['modal']);?>>글내용 - 현재창</option>
				<option value="1"<?php echo get_selected('1', $boset['modal']);?>>글내용 - 모달창</option>
				<option value="2"<?php echo get_selected('2', $boset['modal']);?>>링크#1 - 새창</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">상단검색</td>
		<td>
			<select name="boset[tsearch]">
				<option value="">사용안함</option>
				<?php echo apms_color_options($boset['tsearch']);?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">정렬추가</td>
		<td>
			<label><input type="checkbox" name="boset[scmt]" value="1"<?php echo get_checked('1', $boset['scmt']);?>> 댓글순</label>
			&nbsp;
			<label><input type="checkbox" name="boset[sdload]" value="1"<?php echo get_checked('1', $boset['sdload']);?>> 다운순</label>
			&nbsp;
			<label><input type="checkbox" name="boset[svisit]" value="1"<?php echo get_checked('1', $boset['svisit']);?>> 방문순</label>
			&nbsp;
			<label><input type="checkbox" name="boset[spoll]" value="1"<?php echo get_checked('1', $boset['spoll']);?>> 참여순</label>
			&nbsp;
			<label><input type="checkbox" name="boset[supdate]" value="1"<?php echo get_checked('1', $boset['supdate']);?>> 업데이트순</label>
			&nbsp;
			<label><input type="checkbox" name="boset[sdown]" value="1"<?php echo get_checked('1', $boset['sdown']);?>> 다운점수순</label>
		</td>
	</tr>
	<tr>
		<td align="center" rowspan="2">카테고리</td>
		<td>
			<select name="boset[tab]">
				<?php echo apms_tab_options($boset['tab']);?>
			</select>
			&nbsp;
			<label><input type="checkbox" name="boset[tabline]" value="1"<?php echo get_checked($boset['tabline'], '1');?>> 일반탭 상단라인 출력</label>
			-
			탭/버튼컬러
			<select name="boset[mctab]">
				<?php echo apms_color_options($boset['mctab']);?>
			</select>
		</td>
	</tr>
	<tr>
		<td>
			<label><input type="radio" name="boset[ctype]" value=""<?php echo get_checked('', $boset['ctype']);?>> 일반형</label>
			&nbsp;
			<label><input type="radio" name="boset[ctype]" value="1"<?php echo get_checked('1', $boset['ctype']);?>> 배분형</label>
			&nbsp;
			<label><input type="radio" name="boset[ctype]" value="2"<?php echo get_checked('2', $boset['ctype']);?>> 분할형</label>
			-
			가로 최대 <input type="text" name="boset[bunhal]" value="<?php echo $boset['bunhal'];?>" size="2" class="frm_input"> 개 출력
		</td>
	</tr>
	<tr>
		<td align="center">
			별점색상
		</td>
		<td>
			<select name="boset[vstar]">
				<?php echo apms_color_options($boset['vstar']);?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">버튼컬러</td>
		<td>
			<select name="boset[btn1]">
				<option value="">기본컬러</option>
				<?php echo apms_color_options($boset['btn1']);?>
			</select>
			&nbsp;
			주버튼컬러
			<select name="boset[btn2]">
				<option value="">기본컬러</option>
				<?php echo apms_color_options($boset['btn2']);?>
			</select>

		</td>
	</tr>
	<tr>
		<td align="center">댓글설정</td>
		<td>
			회원사진
			<select name="boset[cmt_photo]">
				<option value=""<?php echo get_selected('', $boset['cmt_photo']); ?>>모두출력</option>
				<option value="1"<?php echo get_selected('1', $boset['cmt_photo']); ?>>PC만</option>
				<option value="2"<?php echo get_selected('2', $boset['cmt_photo']); ?>>모바일만</option>
				<option value="3"<?php echo get_selected('3', $boset['cmt_photo']); ?>>출력안함</option>
			</select>
			&nbsp;
			대댓글 이름
			<select name="boset[cmt_re]">
				<option value=""<?php echo get_selected('', $boset['cmt_re']); ?>>출력안함</option>
				<option value="1"<?php echo get_selected('1', $boset['cmt_re']); ?>>모두</option>
				<option value="2"<?php echo get_selected('2', $boset['cmt_re']); ?>>PC만</option>
				<option value="3"<?php echo get_selected('3', $boset['cmt_re']); ?>>모바일만</option>
			</select>
			&nbsp;
			<label><input type="checkbox" name="boset[cgood]" value="1"<?php echo get_checked('1', $boset['cgood']);?>> 댓글추천</label>
			&nbsp;
			<label><input type="checkbox" name="boset[cnogood]" value="1"<?php echo get_checked('1', $boset['cnogood']);?>> 비추천</label>
		</td>
	</tr>
	<tr>
		<td align="center">태그등록</td>
		<td>
			<select name="boset[tag]">
				<option value="">관리자</option>
				<?php echo apms_grade_options($boset['tag']);?>
			</select>
			등급 이상 회원만 태그등록 허용
		</td>
	</tr>
	</tbody>
	</table>

	<br><br>

	<p><b>■ 목록설정</b></p>
	<table>
	<caption>목록스킨설정</caption>
	<colgroup>
		<col class="grid_2">
		<col>
	</colgroup>
	<thead>
	<tr>
		<th scope="col">구분</th>
		<th scope="col">설정</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td align="center">스타일</td>
		<td>
			<select name="boset[lbody]">
				<option value=""<?php echo get_selected('', $boset['lbody']);?>>기본 스타일</option>
				<option value="box"<?php echo get_selected('box', $boset['lbody']);?>>박스 스타일</option>
				<option value="round"<?php echo get_selected('round', $boset['lbody']);?>>라운드 스타일</option>
				<option value="line"<?php echo get_selected('line', $boset['lbody']);?>>라인 스타일</option>
				<option value="line-round"<?php echo get_selected('line-round', $boset['lbody']);?>>라인 라운드 스타일</option>

			</select>
			&nbsp;
			테두리색
			<select name="boset[lborder]">
				<?php echo apms_color_options($boset['lborder']);?>
			</select>
			&nbsp;
			<select name="boset[shadow]">
				<?php echo apms_shadow_options($boset['shadow']);?>
			</select>
		</td>
	</tr>

	<tr>
		<td align="center">썸네일</td>
		<td>
			<?php echo help('기본 400x300(4:3) - 높이 0 입력시 메이슨리 스타일로 자동 전환');?>
			<input type="text" name="boset[thumb_w]" value="<?php echo $boset['thumb_w'];?>" size="4" class="frm_input">
			x
			<input type="text" name="boset[thumb_h]" value="<?php echo $boset['thumb_h'];?>" size="4" class="frm_input"> px
			-
			확대
			<input type="text" name="boset[thumb_s]" value="<?php echo $boset['thumb_s'];?>" size="4" class="frm_input"> 배 - ex) 유튜브 전용 : 1.35
		</td>
	</tr>
	<tr>
		<td align="center">이미지</td>
		<td>
			<input type="text" name="boset[gap]" value="<?php echo $boset['gap'];?>" size="4" class="frm_input"> px 간격
			(기본 15px)
			&nbsp;
			<label><input type="checkbox" name="boset[vicon]" value="1"<?php echo get_checked('1', $boset['vicon']);?>> 동영상 표시 아이콘 출력안함</label>
		</td>
	</tr>
	<tr>
		<td align="center">텍스트</td>
		<td>
			<input type="text" name="boset[lcont]" value="<?php echo $boset['lcont'];?>" size="4" class="frm_input"> 자 내용
			(기본 0자, 0 미출력)
			-
			제목/내용
			<input type="text" name="boset[cline]" value="<?php echo $boset['cline'];?>" size="4" class="frm_input"> 줄 출력
			(기본 2줄)
		</td>
	</tr>
	<tr>
		<td align="center">목록수</td>
		<td>
			<input type="text" name="bo_page_rows" value="<?php echo $board['bo_page_rows'];?>" size="4" class="frm_input" > 개 - PC
			&nbsp;
			<input type="text" name="bo_mobile_page_rows" value="<?php echo $board['bo_mobile_page_rows'];?>" size="4" class="frm_input" > 개 - 모바일
		</td>
	</tr>
	<tr>
		<td align="center">가로수</td>
		<td>
			<input type="text" name="boset[item]" value="<?php echo $boset['item']; ?>" class="frm_input" size="4"> 개
			(기본 4개, 반응형 기본 lg 3개, md 3개, sm 2개, xs 1개)
			<div class="h10"></div>
			<table>
			<thead>
			<tr>
				<th scope="col">구분</th>
				<th scope="col">lg(1199px~)</th>
				<th scope="col">md(991px~)</th>
				<th scope="col">sm(767px~)</th>
				<th scope="col">xs(480px~)</th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td align="center">가로수</td>
				<td align="center">
					<input type="text" name="boset[lg]" value="<?php echo $boset['lg']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="boset[md]" value="<?php echo $boset['md']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="boset[sm]" value="<?php echo $boset['sm']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="boset[xs]" value="<?php echo $boset['xs']; ?>" class="frm_input" size="4">
				</td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
	<tr>
		<td align="center">보임설정</td>
		<td>
			<label><input type="checkbox" name="boset[lhit]" value="1"<?php echo get_checked('1', $boset['lhit']);?>> 조회</label>
			&nbsp;
			<label><input type="checkbox" name="boset[ldate]" value="1"<?php echo get_checked('1', $boset['ldate']);?>> 날짜</label>
			&nbsp;
			<label><input type="checkbox" name="boset[ldown]" value="1"<?php echo get_checked('1', $boset['ldown']);?>> 다운</label>
			&nbsp;
			<label><input type="checkbox" name="boset[lvisit]" value="1"<?php echo get_checked('1', $boset['lvisit']);?>> 방문</label>
			&nbsp;
			<label><input type="checkbox" name="boset[ldpoint]" value="1"<?php echo get_checked('1', $boset['ldpoint']);?>> 다운점수</label>
		</td>
	</tr>
	<tr>
		<td align="center">숨김설정</td>
		<td>
			<label><input type="checkbox" name="boset[lcate]" value="1"<?php echo get_checked('1', $boset['lcate']);?>> 분류</label>
			&nbsp;
			<label><input type="checkbox" name="boset[lgood]" value="1"<?php echo get_checked('1', $boset['lgood']);?>> 추천</label>
		</td>
	</tr>
	<tr>
		<td align="center">날짜모양</td>
		<td>
			<input type="text" name="boset[dtype]" value="<?php echo $boset['dtype'];?>" size="8" class="frm_input" >
			(Y.m.d, Y/m/d 등 날짜타입)
		</td>
	</tr>
	</tbody>
	</table>

</div>