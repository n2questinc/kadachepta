package kadachepta;

import javax.ws.rs.Consumes;
import javax.ws.rs.DefaultValue;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;
import javax.ws.rs.QueryParam;

import org.apache.logging.log4j.LogManager;
import org.apache.logging.log4j.Logger;

@Path("/reviews")
public class ReviewsService {
	private static final Logger log = LogManager.getLogger(ReviewsService.class);

	/**
	 * kadachepta.com/reviews/artist?name=_name&rating=_rating
	 * @param artistName
	 * @param rating
	 * @return
	 */
	@Path("artist")
	@Produces("text/plain")
	@Consumes({"text/plain, application/json, application/x-www-form-urlencoded"})
	public Integer artistRating(
			@QueryParam("name") String artistName, 
			@DefaultValue("5") @QueryParam("rating") int rating) {
		//TODO - save the artist ratings
		return 0;
	}

	/**
	 * kadachepta.com/reviews/story?name=_name&rating=_rating
	 * @param storyName
	 * @param rating
	 * @return
	 */
	@Path("story")
	@Produces("text/plain")
	@Consumes({"text/plain, application/json, application/x-www-form-urlencoded"})
	public Integer storyRating(
			@QueryParam("name") String storyName, 
			@DefaultValue("5") @QueryParam("rating") String rating) {
		//TODO - save the story ratings
		return 0;
	}
	
}
