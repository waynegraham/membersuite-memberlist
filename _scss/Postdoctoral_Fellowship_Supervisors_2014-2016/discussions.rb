url = 'https://connect.clir.org/communities/community-home?CommunityKey=5c3ce0c3-0b62-4cc2-8a77-e2b6f1097068'
@browser.visit url
login

discussion_path


@browser.save_screenshot("#{@web_dir}/landing.png", full: true)
landing_page = @browser.save_page("#{@web_dir}/landing.html")

get_discussions

clean_landing(landing_page)
