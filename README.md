Hostel management system, is Laravel application where student can register and login, after logged in can request room allocation, can edit and delete request before it’s approval, He/she can check his/her request status(pending, rejected, or approved ) if approved, in which room and which block.
Admin can login and redirected to admin dashboard and see the list of student’s requests with option to reject or approve each of them.
admin has 4 features on dashboard after successful login:
1.	Manage blocks: add, list, edit, and delete block
2.	Manage Room: add on specific block, list, edit, and delete room
3.	Manage Request: list all with ability to reject, approve request (by approve the admin will allocate the student based on gender and number allocation made on that room if it less than 8)
4. manage allocation: list all allocations that have made, edit and delete them 

Student’s dashboard:
1.	See the allocation information on where he/she allocated
2.	Able to request room if not allocated or first request is rejected
3.	Check request status
4.	Edit or delete request before it is approved or rejected
-----------------------------------------------------------------------------------------------------------------
Database structure database named as hostel
1. users
id              (PK)
name
email           (UNIQUE)
password
gender          (ENUM: 'male', 'female')
role            (ENUM: 'student', 'admin')
created_at
updated_at

2. blocks
id              (PK)
name            (e.g., "Block A")
created_at
updated_at

3. rooms
id              (PK)
block_id        (FK → blocks.id)
room_number     (e.g., "Room 101")
gender_allowed  (ENUM: 'male', 'female') -- Optional for gender-based allocation
created_at
updated_at

4. requests
id              (PK)
user_id         (FK → users.id)
status          (ENUM: 'pending', 'approved', 'rejected')
reason          (Nullable, used for rejection reason if any)
created_at
updated_at

5. allocations
id              (PK)
user_id         (FK → users.id)
room_id         (FK → rooms.id)
created_at
updated_at
------------------------------------------------------------------------------------------
Sample data:
-------------------------------------------------------------------------------------------
Admin:
email: admin@hostelms.com
password:admni123

Student:
email:mg@hostelms.com
password:mg12345678
