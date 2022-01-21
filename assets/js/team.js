$(".editteamcls").click(function (e) {
                var pos = $(this).attr("id");
                e.preventDefault();
                $('#teamTypeId').val(pos);
                $('#teamlist').attr('action', "/team/edit").submit();

            });