url = 'https://connect.clir.org/communities/community-home?CommunityKey=5c3ce0c3-0b62-4cc2-8a77-e2b6f1097068'
@browser.visit url
login

members_path
export_members
# member_list = []
# members = @browser.all('.member-email > a')
#
# members.each do |member|
#   member_list << member.text
# end
#
# paginate
#
# puts member_list
