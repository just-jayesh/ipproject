select mocks_users_ans_maths.op_no,mocks_users_ans_maths.q_sr_no,mocks_a_maths.op_no
from mocks_users_ans_maths,mocks_a_maths
where
mocks_users_ans_maths.uname='Ritika'
and
mocks_users_ans_maths.test_no=3
and 
mocks_users_ans_maths.q_sr_no=mocks_a_maths.sr_no
order by mocks_a_maths.sr_no


select mocks_users_ans.op_no,mocks_users_ans.q_sr_no,mocks_a.op_no
from mocks_users_ans,mocks_a
where
mocks_users_ans.uname='Aakash'
and
mocks_users_ans.test_no=18
and 
mocks_users_ans.q_sr_no=mocks_a.sr_no
order by mocks_a.sr_no




RIGHT
======

select count(*)
from mocks_users_ans_maths,mocks_a_maths
where
mocks_users_ans_maths.uname='Ritika'
and
mocks_users_ans_maths.test_no=3
and 
mocks_users_ans_maths.q_sr_no=mocks_a_maths.sr_no
and mocks_users_ans_maths.op_no=mocks_a_maths.op_no
order by mocks_a_maths.sr_no


WRONG
=======
select count(*)
from mocks_users_ans_maths,mocks_a_maths
where
mocks_users_ans_maths.uname='Ritika'
and
mocks_users_ans_maths.test_no=3
and 
mocks_users_ans_maths.q_sr_no=mocks_a_maths.sr_no
and mocks_users_ans_maths.op_no<>mocks_a_maths.op_no
order by mocks_a_maths.sr_no